import { FunctionalComponent } from "vue";

export interface Navigation {
    name: string;
    href: string;
    icon: FunctionalComponent;
    current: boolean;
    role?: "student" | "admin";
}

export interface UserNavigation {
    name: string;
    href: string;
}
