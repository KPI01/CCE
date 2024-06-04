import { Head, Link, usePage } from "@inertiajs/react"

import AdminLayout from "@/Layouts/AdminLayout"
import UserLayout from "@/Layouts/UserLayout"
import { DataTable } from "@/Components/Data/DataTable"
import { Button } from "@/Components/ui/button"
import { PlusCircledIcon } from "@radix-ui/react-icons"

interface Props {
    title: string
    data: any
    columns: any
    isAdmin: boolean
    recurso: string
}

export default function Layout(props: Props) {
    const { auth }: any = usePage().props
    console.log(auth)

    const LayoutComponent = props.isAdmin ? AdminLayout : UserLayout


    return (
        <LayoutComponent>
            <Head title={`Recurso: ${props.title}`} />
            <div className="flex justify-between my-10">
                <h1 className="font-semibold text-4xl">{props.title}</h1>
                <Button asChild>
                    <Link className="flex gap-2" href={route(`recurso.${props.recurso}.create`)}>
                            Crear
                    </Link>
                </Button>
            </div>
            <DataTable data={props.data} columns={props.columns} />
        </LayoutComponent >
    )
}
