import { InitialTableState } from "@tanstack/react-table";
import { PropsWithChildren } from "react";

interface NavbarProps extends PropsWithChildren {
    username: string
    email: string
    isAdmin: boolean
}

interface MainLayoutProps extends PropsWithChildren {
    className?: string
}

interface TableProps {
    title: string
    data: any
    columns: any
    recurso: string
    initialVisibility: any
}

export interface LayoutProps extends PropsWithChildren {
    pageTitle: string
    mainTitle: string
    recurso: string
}
