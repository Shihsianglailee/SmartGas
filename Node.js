const express = require('express');
const app = express();
const port = 3000;

app.get('http://localhost/test/Show_Company_Name.php', (req, res) => {
    res.json({
        companyName: 'Smart Gas Co.',
        customerId: '12345',
        companyId: '67890'
    });
});

app.get('http://localhost/test/Show_IOT.php', (req, res) => {
    res.json([
        { sensorId: 'Sensor1', volume: 20.5, time: '2024-08-20 10:00:00' },
        { sensorId: 'Sensor2', volume: 15.0, time: '2024-08-20 09:30:00' }
    ]);
});

app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
