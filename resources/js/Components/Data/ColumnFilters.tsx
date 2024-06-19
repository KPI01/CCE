import { Meta } from "@/types"

import { Table } from "@tanstack/react-table"

import { Input } from "@/Components/ui/input"
import { Button } from "@/Components/ui/button"
import {
    Select,
    SelectContent,
    SelectTrigger,
    SelectValue,
    SelectItem
} from "@/Components/ui/select"
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/Components/ui/sheet"
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from "@/Components/ui/accordion"
import { Search } from "lucide-react"


interface DataTableViewOptionsProps<TData> {
    table: Table<TData>
    filterState: any[]
    setFilterState: any
}
export default function ColumnFilters<TData>({
    table,
    filterState,
    setFilterState,
}: DataTableViewOptionsProps<TData>) {
    return (
        <Sheet>
            <SheetTrigger asChild>
                <Button
                    variant={table.getState().columnFilters.length > 0 ? "default" : "outline"}
                    size={'sm'}
                    className="h-8"
                    >
                    <Search className="mr-2 h-4 w-4"/>
                    Filtros
                    {table.getState().columnFilters.length > 0 ? <span className="text-sm font-medium">({table.getState().columnFilters.length})</span> : null}
                </Button>
            </SheetTrigger>
            <SheetContent className="w-96 overflow-auto">
                <SheetHeader>
                    <SheetTitle className="font-bold text-xl">
                        Filtros
                    </SheetTitle>
                    <SheetDescription>
                        Selecciona los filtros que desees.
                    </SheetDescription>
                    <div className="flex flex-col items-start gap-10">
                        <div>
                            <Button variant={"destructive"} size={'sm'} onClick={() => table.resetColumnFilters()}>Limpiar filtros</Button>
                        </div>
                        <div className="flex flex-col gap-8 w-full">
                            {table.getAllColumns().map((column) => {
                                if (column.getCanFilter()) {
                                    let info = column.columnDef.meta as Meta
                                    if (info.tipo == 'select') {
                                        return (
                                            <Accordion key={column.id} type="single" collapsible className="w-full">
                                                <AccordionItem value={column.id}>
                                                    <AccordionTrigger>{info.header}</AccordionTrigger>
                                                    <AccordionContent>
                                                        <Select open onValueChange={value => {
                                                            // console.log(columnFilters)
                                                            const meta = column.columnDef.meta as Meta
                                                            let val = value === '*' ? undefined : value
                                                            let copyFilters = filterState
                                                            if (copyFilters.find((filter) => filter.id === meta.key)) {
                                                                copyFilters.map((filter) => {
                                                                    if (filter.id === meta.key) {
                                                                        filter.value = val
                                                                    }
                                                                })
                                                            } else {
                                                                copyFilters.push({ id: meta.key, value: val })
                                                            }

                                                            // console.log('Copia', copyFilters)
                                                            setFilterState(copyFilters)
                                                        }}>
                                                            <SelectTrigger>
                                                                <SelectValue placeholder={table.getColumn(info.key)?.getFilterValue() as string ?? "Todos"} />
                                                            </SelectTrigger>
                                                            <SelectContent>
                                                                {info.options?.map((option) => {
                                                                    const curr = table.getColumn(info.key)?.getFilterValue() ? table.getColumn(info.key)?.getFilterValue() : '*'
                                                                    // console.log('curr', curr)
                                                                    let text = option !== '*' ? option : 'Todos'
                                                                    return (
                                                                        <SelectItem key={option} value={option} {...(option === curr ? { 'data-state': 'checked' } : {})}>
                                                                            {text}
                                                                        </SelectItem>)
                                                                })}
                                                            </SelectContent>
                                                        </Select>
                                                    </AccordionContent>
                                                </AccordionItem>
                                            </Accordion>
                                        )
                                    }
                                    return (
                                        <Accordion key={column.id} type="single" collapsible className="w-full scroll-auto">
                                            <AccordionItem value={column.id}>
                                                <AccordionTrigger>{info.header}</AccordionTrigger>
                                                <AccordionContent>
                                                    <Input
                                                        placeholder={`${info.header.toLowerCase()}...`}
                                                        value={(table.getColumn(info.key)?.getFilterValue() as string) ?? ""}
                                                        onChange={(e) =>
                                                            table.getColumn(info.key)?.setFilterValue(e.target.value)
                                                        }
                                                        className="max-w-sm"
                                                    />
                                                </AccordionContent>
                                            </AccordionItem>
                                        </Accordion>
                                    )
                                }
                            })
                            }
                        </div>
                    </div>
                </SheetHeader>
            </SheetContent>
        </Sheet>
    )
}
