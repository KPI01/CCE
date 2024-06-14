import { Head, Link, usePage } from "@inertiajs/react"

import { DataTable } from "@/Components/Data/DataTable"
import { Button } from "@/Components/ui/button"
import MainLayout from "./MainLayout"

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

    return (
        <MainLayout>
            <Head title={`Recurso: ${props.title}`} />
            <div className="flex justify-between my-10">
                <h1 className="font-semibold text-4xl">{props.title}</h1>
                <Button asChild size={"lg"} className="text-lg">
                    <Link href={route(`${props.recurso}.create`)}>
                            Crear
                    </Link>
                </Button>
            </div>
            <DataTable data={props.data} columns={props.columns} rc={props.recurso}/>
        </MainLayout>
    )
}
