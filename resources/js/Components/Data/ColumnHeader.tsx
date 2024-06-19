import {
    ArrowDownIcon,
    ArrowUpIcon,
    CaretSortIcon,
    EyeNoneIcon,
} from "@radix-ui/react-icons"
import { Column } from "@tanstack/react-table"

import { cn } from "@/lib/utils"
import { Button } from "@/Components/ui/button"
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu"
import { CircleEllipsis, EllipsisVertical } from "lucide-react"

interface DataTableColumnHeaderProps<TData, TValue>
    extends React.HTMLAttributes<HTMLDivElement> {
    column: Column<TData, TValue>
    title: string
}

export function DataTableColumnHeader<TData, TValue>({
    column,
    title,
    className,
}: DataTableColumnHeaderProps<TData, TValue>) {
    if (!column.getCanSort() && !column.getCanHide()) {
        return <div className={cn(className)}>{title}</div>
    }

    return (
        <div className={cn("flex items-center space-x-2 px-3", className)}>
            <DropdownMenu>
                <DropdownMenuTrigger asChild>
                    <Button
                        variant="ghost"
                        size="sm"
                        className="-ml-3 h-8 data-[state=open]:bg-accent"
                    >
                        <span>{title}</span>
                        {column.getIsSorted() === "desc" ? (
                            <ArrowDownIcon className="ml-2 h-4 w-4" />
                        ) : column.getIsSorted() === "asc" ? (
                            <ArrowUpIcon className="ml-2 h-4 w-4" />
                        ) : (
                            <EllipsisVertical className="ml-2 h-4 w-4" />
                        )}
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="start">
                    {column.getCanSort() && (
                        <>
                            <DropdownMenuItem onClick={() => column.toggleSorting(false)} className="cursor-pointer">
                                <ArrowUpIcon className="mr-2 h-3.5 w-3.5 text-muted-foreground/70 cursor-pointer" />
                                Asc
                            </DropdownMenuItem>
                            <DropdownMenuItem onClick={() => column.toggleSorting(true)} className="cursor-pointer">
                                <ArrowDownIcon className="mr-2 h-3.5 w-3.5 text-muted-foreground/70" />
                                Desc
                            </DropdownMenuItem>
                        </>
                    )}
                    <DropdownMenuSeparator />
                    {column.getCanHide() && (
                        <DropdownMenuItem onClick={() => column.toggleVisibility(false)} className="cursor-pointer">
                            <EyeNoneIcon className="mr-2 h-3.5 w-3.5 text-muted-foreground/70" />
                            Ocultar
                        </DropdownMenuItem>
                    )
                    }
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    )
}
