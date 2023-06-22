// Get count down container
const elements = [
    ...document.querySelectorAll(
        ".elementor-widget-container .elementor-addon--count-down"
    ),
];

elements.forEach((item) => {
    /**
     * Get elements
     */
    const secondsElement = item.querySelector(".seconds span");
    const minutesElement = item.querySelector(".minutes span");
    const hoursElement = item.querySelector(".hours span");
    const daysElement = item.querySelector(".days span");

    // Timer
    const timer = setInterval(countDown, 1000);

    function countDown() {
        const time = {
            day: parseInt(daysElement.textContent),
            hour: parseInt(hoursElement.textContent),
            minute: parseInt(minutesElement.textContent),
            second: parseInt(secondsElement.textContent),
        };

        // second
        if (time.second === 0) {
            // minute
            if (time.minute === 0) {
                // hour
                if (time.hour === 0) {
                    // Day
                    if (time.day === 0) {
                        // Stop time
                        clearInterval(timer);
                        return;
                    } else if (time.day < 11) {
                        daysElement.textContent = `0${time.day - 1}`;
                    } else {
                        daysElement.textContent = time.day - 1;
                    }
                    // Reset hour
                    hoursElement.textContent = 23;
                } else if (time.hour < 11) {
                    hoursElement.textContent = `0${time.hour - 1}`;
                } else {
                    hoursElement.textContent = time.hour - 1;
                }
                // Reset second
                minutesElement.textContent = 59;
            } else if (time.minute < 11) {
                minutesElement.textContent = `0${time.minute - 1}`;
            } else {
                minutesElement.textContent = time.minute - 1;
            }
            // Reset second
            secondsElement.textContent = 59;
        } else if (time.second < 11) {
            secondsElement.textContent = `0${time.second - 1}`;
        } else {
            secondsElement.textContent = time.second - 1;
        }
    }
});
