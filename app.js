document.addEventListener("DOMContentLoaded", function () {
    const codeReader = new ZXing.BrowserQRCodeReader();
    const videoElement = document.getElementById('preview');
    const inputNewGasId = document.getElementById('inputNewGasId');
    const confirmNewScanButton = document.getElementById('confirmNewScanButton');
    const gasType = document.getElementById('gasType');
    const initialVolume = document.getElementById('initialVolume');
    const gasWeightEmpty = document.getElementById('gasWeightEmpty');

    // Start QR Code Scanner
    codeReader.decodeFromVideoDevice(null, videoElement, (result, err) => {
        if (result) {
            inputNewGasId.value = result.text;
            fetchGasData(result.text);
        }
    });

    // Fetch Gas Data when Gas ID is entered manually
    inputNewGasId.addEventListener('input', function () {
        if (inputNewGasId.value.trim()) {
            fetchGasData(inputNewGasId.value.trim());
        } else {
            clearGasData();
        }
    });

    // Function to fetch Gas Data
    function fetchGasData(gasId) {
        fetch('http://localhost/test/Show_Gas_Info.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${encodeURIComponent(gasId)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.response === 'failure') {
                    alert('This gas cylinder is not registered.');
                    window.location.href = 'NewGasRegister.html';
                } else {
                    gasType.textContent = data.GAS_Type;
                    initialVolume.textContent = data.GAS_Volume;
                    gasWeightEmpty.textContent = data.GAS_Weight_Empty;
                    saveIot(gasId, data.GAS_Weight_Empty, "yourSensorIdHere");
                }
            })
            .catch(error => console.error('Error fetching gas data:', error));
    }

    // Function to clear Gas Data
    function clearGasData() {
        gasType.textContent = '';
        initialVolume.textContent = '';
        gasWeightEmpty.textContent = '';
    }

    // Function to save IoT data
    function saveIot(gasId, gasWeightEmpty, sensorId) {
        fetch('http://localhost/test/scanNewGas_iot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `gasId=${encodeURIComponent(gasId)}&gasWeightEmpty=${encodeURIComponent(gasWeightEmpty)}&sensorId=${encodeURIComponent(sensorId)}`
        })
            .then(response => response.text())
            .then(response => {
                if (response.includes('success')) {
                    window.location.href = 'exchangeSucceed.html';
                } else {
                    window.location.href = 'ExchangeScanFailed.html';
                }
            })
            .catch(error => console.error('Error saving IoT data:', error));
    }

    // Handle button click event
    confirmNewScanButton.addEventListener('click', function () {
        if (inputNewGasId.value.trim() === '') {
            window.location.href = 'NewGasRegister.html';
        } else {
            fetchGasData(inputNewGasId.value.trim());
        }
    });
});
