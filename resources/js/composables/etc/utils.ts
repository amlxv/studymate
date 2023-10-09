export const calculateDaysDifferenceByDayName = (
    from: string,
    to: string,
    days: Array<string>,
): number => {
    const firstDay = new Date(0).getDay() + days.indexOf(from);
    const secondDay = new Date(0).getDay() + days.indexOf(to);

    let daysDifference = secondDay - firstDay;

    if (daysDifference < 0) {
        daysDifference += 7;
    }

    return daysDifference;
};

export const days: string[] = [
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
    "Sunday",
];
