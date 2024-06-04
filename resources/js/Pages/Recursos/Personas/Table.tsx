"user server"

import DataLayout from "@/Layouts/DataLayout"

import { columns } from "./Column"

import { Persona } from "@/types"

interface Props {
    data: Persona[],
    isAdmin: boolean
}

export default function Page(props: Props) {

    return (
        <DataLayout title="Personas" isAdmin={props.isAdmin} data={props.data} columns={columns} recurso="persona"/>
    )


}
