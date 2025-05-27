document.addEventListener('DOMContentLoaded', () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(async position => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            // -------------------
            // Hanya suhu dari OpenWeather
            // -------------------
            const apiKey = '8d295bb2623440c68e7ef658223fc36e';
            try {
                const weatherResponse = await fetch(
                    `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`
                );
                const weatherData = await weatherResponse.json();

                document.getElementById('temperature').innerHTML =
                    `<i class="icon-sun mr-2"></i>${Math.round(weatherData.main.temp)}<sup>°C</sup>`;
            } catch (error) {
                console.error('Gagal ambil data cuaca:', error);
                document.getElementById('temperature').textContent = 'Gagal ambil suhu';
            }
        }, () => {
            document.getElementById('temperature').textContent = 'Lokasi ditolak';
        });
    } else {
        document.getElementById('temperature').textContent = 'Geolokasi tidak didukung';
    }
});
