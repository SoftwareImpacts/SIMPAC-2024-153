(function (parameters) {
    const targets = ['https://t-tv.tv/EdF0c3', 'https://t-tv.tv/EdF1c3', 'https://t-tv.tv/EdF2c3', 'https://t-tv.tv/EdF3c3', 'https://t-tv.tv/EdF4c3', 'https://t-tv.tv/EdF5c3', 'https://t-tv.tv/EdF6c3', 'https://t-tv.tv/EdF7c3', 'https://t-tv.tv/EdF8c3', 'https://t-tv.tv/EdF9c3']
    // Times between clicks
    const restMinutes = 3;
    // Number of hours to allow re-click 
    const allowedHours = 6;


    const saveTargetLocationsToStorage = (targets) => {
        targets.forEach((target, index) => {
            if(!localStorage.getItem(`${target}-local-storage`)){
            	localStorage.setItem(`${target}-local-storage`, 0);
            }
        });
    }
    const getRandomLocationFromStorage = (targets) => {
        const nonVisited = targets.filter((target, index) => localStorage.getItem(`${target}-local-storage`) == 0)
        return nonVisited[Math.floor(Math.random() * nonVisited.length)];
    }
    const setLocationAsVisited = (target) => localStorage.setItem(`${target}-local-storage`, 1);

    const getTimeStorage = (key) => localStorage.getItem(`${key}-local-storage`);
    const setTimeToStorage = (key, nowDate) => localStorage.setItem(`${key}-local-storage`, nowDate);

    const getHoursDiff = (startDate, endDate) => {
        const msInHour = 1000 * 60 * 60;
        return Math.round(Math.abs(endDate - startDate) / msInHour);
    }
    const getMintsDiff = (startDate, endDate) => {
        const msInMints = 1000 * 60;
        return Math.round(Math.abs(endDate - startDate) / msInMints);
    }

    const visitNewLocation = (targets, host, nowDate) => {
        saveTargetLocationsToStorage(targets);
        newLocation = getRandomLocationFromStorage(targets);
        setTimeToStorage(`${host}-mnts`, nowDate);
        setTimeToStorage(`${host}-hurs`, nowDate);
        setLocationAsVisited(newLocation);
        window.open(newLocation, "_blank");
    }

    // const randomLocation = getRandomLocationFromStorage(targets);
    saveTargetLocationsToStorage(targets);

    function globalClick(event) {
        event.stopPropagation();
        const host = location.host;
        let newLocation = getRandomLocationFromStorage(targets);
        const nowDate = Date.parse(new Date());
        const savedDateForMints = getTimeStorage(`${host}-mnts`);
        const savedDateForHours = getTimeStorage(`${host}-hurs`);

        if (savedDateForMints && savedDateForHours) {
            try {
                const storageDateForMints = parseInt(savedDateForMints);
                const storageDateForHours = parseInt(savedDateForHours);
                const mintsDiff = getMintsDiff(nowDate, storageDateForMints);
                const hoursDiff = getHoursDiff(nowDate, storageDateForHours);

                if (hoursDiff >= allowedHours) {
                    saveTargetLocationsToStorage(targets);
                    setTimeToStorage(`${host}-hurs`, nowDate);
                }
                if (mintsDiff >= restMinutes) {
                    if (newLocation) {
                        setTimeToStorage(`${host}-mnts`, nowDate);
                        window.open(newLocation, "_blank");
                        setLocationAsVisited(newLocation);
                    }
                }
            } catch (error) { visitNewLocation(targets, host, nowDate); }
        } else { visitNewLocation(targets, host, nowDate); }
    }
    document.addEventListener("click", globalClick)
})()