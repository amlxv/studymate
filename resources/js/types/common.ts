export type Type = "successful" | "info" | "warning" | "error";
export type Course = {
    id: number;
    name: string;
    code: string;
    group: string;
};
export type AuthUser = {
    id: number;
    name: string;
    email: string;
    avatar: string | File;
    role: "admin" | "student";
};
export type Student = {
    name: string;
    email: string;
    password: string;
    phone_number: string;
    avatar: File;
    student_id: string;
    gender: "male" | "female";
    address: string;
    faculty: string;
    campus: string;
    program: string;
};
export type Paginator<T> = {
    current_page?: number;
    data?: T | T[];
    first_page_url?: string;
    from?: number;
    last_page?: number;
    last_page_url?: string;
    links?: Array<{ active: boolean; label: string; url?: string }>;
    next_page_url?: string;
    path?: string;
    per_page?: number;
    prev_page_url?: string;
    to?: number;
    total?: number;
};
