import { Ziggy } from "../../ziggy";

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

export const getImagePath = (path: string): string => {
    // @ts-ignore
    return path.includes("http")
        ? path
        : `${new URL(window.location.toString()).origin}/${path}`;
};

export const getRoute = (path: string): string => {
    return `${new URL(window.location.toString()).origin}/${
        Ziggy.routes[path].uri
    }`;
};
