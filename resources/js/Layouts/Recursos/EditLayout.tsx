import { LayoutProps } from "@/types";
import MainLayout from "@/Layouts/MainLayout"
import { Head } from "@inertiajs/react";
import FormHeader from "./FormHeader";

export default function EditLayout({
    children,
    recurso = 'personas',
    mainTitle,
    pageTitle
}: LayoutProps) {
    return (
        <MainLayout>
            <Head title={pageTitle} />
                <FormHeader title={mainTitle} recurso={recurso} />
                {children}
        </MainLayout>
    )
}
