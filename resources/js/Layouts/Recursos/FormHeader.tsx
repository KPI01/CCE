import { Button } from "@/Components/ui/button"
import { Separator } from "@/Components/ui/separator"
import { Link } from "@inertiajs/react"
import { ChevronLeft } from "lucide-react"

interface Props {
    recurso: string
    title: string
    updated?: Date | never
}

export default function FormHeader({
    recurso,
    title,
    updated
}: Props) {
    return (
        <div className="flex items-center gap-4">
            <Button variant={'outline'} size={'sm'} className="px-2 py-1" asChild>
                <Link href={route(`${recurso}.index`)} as="button">
                    <ChevronLeft className="h-4" />
                </Link>
            </Button>
            <Separator orientation="vertical" className="h-10" />
            <div className="flex gap-4">
                <div className="flex flex-col">
                    <h1 className="font-bold text-5xl my-3">{title}</h1>
                    {updated && (
                        <span className="text-sm text-primary/25 ml-4">Última actualización: {updated.toLocaleString()} { }</span>
                    )}
                </div>
            </div>
        </div>
    )

}
