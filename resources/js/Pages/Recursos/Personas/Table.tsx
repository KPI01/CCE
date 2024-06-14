"user server"

import DataLayout from "@/Layouts/DataLayout"

import { columns } from "./Column"

import { Persona } from "@/types"
import { usePage } from "@inertiajs/react"

interface Props {
    data: Persona[],
    isAdmin: boolean
}

export default function Page(props: Props) {
    const pageProps = usePage().props
    console.log(pageProps)

    return (
        <DataLayout title="Personas" isAdmin={props.isAdmin} data={props.data} columns={columns} recurso="personas" />
    )


}
