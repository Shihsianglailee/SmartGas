// remain_gas.js

document.addEventListener('DOMContentLoaded', function () {
    const scanNewGasBtn = document.getElementById('scanNewGas');
    const companyNameText = document.getElementById('companyName');
    const remainGasList = document.getElementById('remainGasList');
    let order_Id = '110'; // replace with dynamic data if needed
    let Customer_Id = '';
    let Company_id = '';
    let remainGasVolumnList = [];
    let finalSensorId = [];
    let sensorTime = [];
    let total_volume = 0;

    async function fetchData(url, id) {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ id: id })
            });
            const result = await response.text();
            return result;
        } catch (error) {
            console.error('Fetch Data Error:', error);
            return null;
        }
    }

    async function loadCompanyNameAndSensorData() {
        try {
            let result = await fetchData('http://localhost/test/Show_Company_Name.php', order_Id);
            const responseJSON = JSON.parse(result);
            const Company_Name = responseJSON.Company_Name;
            companyNameText.textContent = Company_Name;
            Customer_Id = responseJSON.Customer_Id;
            Company_id = responseJSON.COMPANY_Id;

            result = await fetchData('http://localhost/test/Show_IOT.php', Customer_Id);

            if (result.includes('Warning')) {
                alert('此客戶尚未註冊IOT');
            } else {
                const sensors = JSON.parse(result);
                sensors.forEach((sensor, index) => {
                    const sensorWeight = parseFloat(sensor.SENSOR_Weight);
                    const time = sensor.SENSOR_Time;

                    remainGasVolumnList.push(sensorWeight);
                    finalSensorId.push(sensor.SENSOR_Id);
                    sensorTime.push(time);

                    const listItem = document.createElement('li');
                    listItem.innerHTML = `感應器: ${sensor.SENSOR_Id}\n${sensorWeight} 公斤 `;
                    
                    // Create and append the delete button
                    const deleteBtn = document.createElement('button');
                    deleteBtn.textContent = '刪除';
                    deleteBtn.addEventListener('click', function() {
                        removeSensorData(index, listItem);
                    });
                    listItem.appendChild(deleteBtn);

                    remainGasList.appendChild(listItem);
                });
            }
        } catch (error) {
            console.error('Load Data Error:', error);
        }
    }

    function removeSensorData(index, listItem) {
        // Remove data from arrays
        remainGasVolumnList.splice(index, 1);
        finalSensorId.splice(index, 1);
        sensorTime.splice(index, 1);

        // Remove the list item from the UI
        remainGasList.removeChild(listItem);

        // Optional: Show a confirmation message
        alert('Sensor data removed successfully');
    }

    async function saveVolume() {
        try {
            const response = await fetch('http://localhost/test/Save_RemainGas.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    id: Customer_Id,
                    gas: total_volume,
                    company: Company_id
                })
            });

            const result = await response.text();
            if (result.includes('success')) {
                alert('Successfully stored GasRemain.');
                window.location.href = 'scan_new_qr_code.html'; // Redirect to next page
            } else {
                console.error('Save Volume Error:', result);
            }
        } catch (error) {
            console.error('Save Volume Exception:', error);
        }
    }

    scanNewGasBtn.addEventListener('click', function () {
        if (remainGasVolumnList.length === 1 && finalSensorId.length === 1) {
            try {
                const currentDateTime = new Date();
                const sensorDateTime = new Date(sensorTime[0]);

                const timeDifferenceMinutes = Math.abs(currentDateTime - sensorDateTime) / (1000 * 60);

                if (timeDifferenceMinutes <= 30) {
                    total_volume += remainGasVolumnList[0];
                    saveVolume();
                } else {
                    alert('請先更新感應器重量');
                }
            } catch (error) {
                console.error('Volume Calculation Error:', error);
            }
        } else {
            alert('僅留一個感應器, 以便做殘氣計算');
        }
    });

    loadCompanyNameAndSensorData();
});
