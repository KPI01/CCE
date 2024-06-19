import { Head } from "@inertiajs/react"

import MainLayout from "@/Layouts/MainLayout"
import { LayoutProps } from "@/types"
import FormHeader from "./FormHeader"

interface Props extends LayoutProps {
    updated_at: string
}

export default function ShowLayout({
    children,
    pageTitle,
    updated_at,
    recurso = 'personas'
}: Props) {
    let updated = new Date(updated_at)
    console.log(updated)

    return (
        <MainLayout>
            <Head title={pageTitle} />
                <FormHeader title={pageTitle} updated={updated} recurso={recurso}/>
                {children}
        </MainLayout>
    )
}
