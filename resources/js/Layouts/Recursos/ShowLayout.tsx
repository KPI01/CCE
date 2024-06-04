import { ReactNode } from "react"
import { Head, Link } from "@inertiajs/react"
import { ArrowLeftIcon } from "@radix-ui/react-icons"

import UserLayout from "@/Layouts/UserLayout"
import AdminLayout from "@/Layouts/AdminLayout"
import { Separator } from "@/Components/ui/separator"
import { Button } from "@/Components/ui/button"

interface Props {
    children: ReactNode
    isAdmin: boolean
    pageTitle: string
    title: string
    updated_at: string
    recurso: string
}

export default function ShowLayout(props: Props) {
    let Layout = props.isAdmin ? AdminLayout : UserLayout
    let updated = new Date(props.updated_at)
    console.log(updated)

    return (
        <Layout>
            <Head title={props.pageTitle} />
            <div className="flex flex-col my-5 mx-32">
                <div className="flex items-center gap-4">
                    <Button variant={'ghost'} className="px-2 py-1" asChild>
                        <Link href={route(`recurso.${props.recurso}.index`)}>
                            <ArrowLeftIcon width={32} height={32} />
                        </Link>
                    </Button>
                    <Separator orientation="vertical" className="h-10" />
                    <div className="flex flex-col gap-4">
                    <h1 className="font-bold text-5xl">{props.title}</h1>
                    <span className="text-sm text-primary/25">Última actualización: {updated.toLocaleString()} {}</span>
                    </div>
                </div>
                {props.children}
            </div>
        </Layout>
    )
}
