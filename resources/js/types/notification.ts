import * as _ from "lodash";
import { FunctionalComponent } from "vue";
import {
    CheckCircleIcon,
    InformationCircleIcon,
    ExclamationTriangleIcon,
    XCircleIcon,
} from "@heroicons/vue/24/outline";
import type { Type } from "./common";

interface CommonNotification {
    type: Type;
    icon: Icon;
    backgroundColor: string;
    textColor: string;
}

export interface Notification {
    type: Type;
    message: string;
    icon: Icon;
    backgroundColor: string;
    textColor: string;
}

interface Icon {
    component: FunctionalComponent;
    color: string;
}

const commonNotifications: CommonNotification[] = [
    {
        type: "successful",
        icon: {
            component: CheckCircleIcon,
            color: "text-green-400",
        },
        backgroundColor: "bg-green-50",
        textColor: "text-green-800",
    },
    {
        type: "info",
        icon: {
            component: InformationCircleIcon,
            color: "text-blue-400",
        },
        backgroundColor: "bg-blue-50",
        textColor: "text-blue-700",
    },
    {
        type: "warning",
        icon: {
            component: ExclamationTriangleIcon,
            color: "text-yellow-400",
        },
        backgroundColor: "bg-yellow-50",
        textColor: "text-yellow-800",
    },
    {
        type: "error",
        icon: {
            component: XCircleIcon,
            color: "text-red-400",
        },
        backgroundColor: "bg-red-50",
        textColor: "text-red-800",
    },
];

/** Slugs translations **/
const commonSlugMessages = [
    {
        slug: "verification-link-sent",
        message: "We have sent the verification link to your email address!",
    },
];

const getMessage = (message: string) => {
    if (_.find(commonSlugMessages, { slug: message })) {
        return (<{ slug: string; message: string }>(
            _.find(commonSlugMessages, { slug: message })
        )).message;
    }

    return message;
};

export const sanitizeNotification = (
    status: unknown,
    explicitType: Type | null = null,
) => {
    const notification: Notification = {
        type: undefined,
        message: undefined,
        icon: undefined,
        backgroundColor: undefined,
        textColor: undefined,
    };

    switch (typeof status) {
        case "object": {
            if (!status) return;

            notification.type = <Type>_.keys(status)[0];
            notification.message = getMessage(<string>_.values(status)[0]);
            notification.icon = _.find(
                commonNotifications,
                (item: CommonNotification) => item?.type === _.keys(status)[0],
            )?.icon;

            break;
        }

        case "string": {
            notification.type = explicitType ? explicitType : "successful";
            notification.message = getMessage(status);
            notification.icon = _.find(
                commonNotifications,
                (item: CommonNotification) =>
                    item?.type === (explicitType ? explicitType : "successful"),
            ).icon;
            notification.backgroundColor = _.find(
                commonNotifications,
                (item: CommonNotification) =>
                    item?.type === (explicitType ? explicitType : "successful"),
            ).backgroundColor;
            notification.textColor = _.find(
                commonNotifications,
                (item: CommonNotification) =>
                    item?.type === (explicitType ? explicitType : "successful"),
            ).textColor;
            break;
        }

        default: {
            return null;
        }
    }

    return notification;
};
