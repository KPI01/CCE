import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,

} from "@/Components/ui/dropdown-menu"
import {
    FileTextIcon,
    Pencil2Icon
} from "@radix-ui/react-icons"
import { Button } from "@/Components/ui/button"
import { Link } from "@inertiajs/react"
import { MoreHorizontal } from "lucide-react"
import { UUID } from "@/types"

interface Props {
    routeName: string
    item: UUID
}

export default function Actions(props: Props) {
    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button variant="ghost" className="h-8 w-8 p-0">
                    <span className="sr-only">Menú</span>
                    <MoreHorizontal className="h-4 w-4" />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuItem asChild className="cursor-pointer">
                    <Link href={route(props.routeName, props.item)}>
                        <FileTextIcon className="mr-2 h-4 w-4" />
                        Ver detalles
                    </Link>
                </DropdownMenuItem>
                <DropdownMenuItem>
                    <Pencil2Icon className="mr-2 h-4 w-4" />
                    Editar
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    )
}
