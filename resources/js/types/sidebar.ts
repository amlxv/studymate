import { FunctionalComponent } from "vue";

export interface Navigation {
    name: string;
    href: string;
    icon: FunctionalComponent;
    current: boolean;
}
