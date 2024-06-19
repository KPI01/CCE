import { Head, Link, usePage } from "@inertiajs/react"
import { InitialTableState } from "@tanstack/react-table"
import { TableProps } from "@/types"

import MainLayout from "./MainLayout"
import { DataTable } from "@/Components/Data/DataTable"
import { Button } from "@/Components/ui/button"

export default function DataLayout({
    title,
    recurso,
    data,
    columns,
    initialVisibility
}: TableProps) {
    return (
        <MainLayout>
            <Head title={`Recurso: ${title}`} />
            <div className="flex justify-between my-10">
                <h1 className="font-semibold text-4xl">{title}</h1>
                <Button asChild size={"lg"} className="text-lg">
                    <Link href={route(`${recurso}.create`)} as="button">
                            Crear
                    </Link>
                </Button>
            </div>
                <DataTable data={data} columns={columns} initialVisibility={initialVisibility}/>
        </MainLayout>
    )
}
