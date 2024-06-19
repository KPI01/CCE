import {
    Card,
    CardDescription,
    CardHeader
} from "@/Components/ui/card"
import { Input } from "@/Components/ui/input"
import { Label } from "@/Components/ui/label"
import { Separator } from "@/Components/ui/separator"
import { Textarea } from "@/Components/ui/textarea"
import ShowLayout from "@/Layouts/Recursos/ShowLayout"
import { LayoutProps, Persona } from "@/types"
import { Link } from "@inertiajs/react"
import {
    Accordion,
    AccordionItem,
    AccordionTrigger,
    AccordionContent
} from "@/Components/ui/accordion"
import { Building } from "lucide-react"

interface Props extends LayoutProps  {
    data: Persona
}

function Title({ title }: { title: string }) {
    return (
        <h3 className="font-semibold text-2xl mb-4">{title}</h3>
    )
}

function ItemProperty({ title, value, textarea = false }: { title: string, value: string, textarea?: boolean }) {
    value = value === null ? '' : value
    return (
        <div className="grid grid-cols-[8ch_1fr] items-center basis-auto">
            {textarea
                ? (
                    <>
                        <div className="grid w-full gap-1.5 col-span-2">
                            <Label className="mb-2" htmlFor={`val-${title}`}>{title}</Label>
                            <Textarea className="w-full" id={`val-${title}`} value={value} disabled cols={35} rows={2} />
                        </div>
                    </>
                )
                : (<>
                    <Label htmlFor={`val-${title}`} className="text-start w-fit">{title}</Label>
                    <Input
                        id={`val-${title}`}
                        className="w-[35ch] mx-7"
                        type="text"
                        disabled
                        value={value}
                    />
                </>
                )}
        </div>
    )
}

export default function Show(props: Props) {
    let relations = {
        empresas: props.data.empresas ?? undefined
    }
    return (
        <ShowLayout
            pageTitle="Persona"
            mainTitle={`${props.data.nombres} ${props.data.apellidos}`}
            updated_at={props.data.updated_at}
            recurso="personas"
        >
            <div className="flex flex-col items-start gap-8 pt-10 px-48">
                <div>
                    <Title title="Datos básicos" />
                    <div className="flex items-start justify-start gap-3 pt-4 flex-wrap basis-full">
                        <ItemProperty title={props.data.tipo_id_nac} value={props.data.id_nac} />
                        <ItemProperty title="Correo" value={props.data.email} />
                        <ItemProperty title="Teléfono" value={props.data.tel} />
                        <ItemProperty title="Perfil" value={props.data.perfil} />
                    </div>
                    <div className="flex items-start gap-x-12 my-12">
                        <ItemProperty title="Observaciones" value={props.data.observaciones} textarea />
                    </div>
                </div>
                <div className="w-full">
                    <Accordion type="single" collapsible className="w-full">
                        {relations.empresas !== undefined && relations.empresas.length > 0 &&
                            (
                                <>
                                    <AccordionItem value='empresas'>
                                        <AccordionTrigger>
                                            <Title title={`Empresas (${props.data.empresas?.length})`} />
                                        </AccordionTrigger>
                                        <AccordionContent className="flex">
                                            {props.data.empresas?.map(i => {
                                                return (
                                                    <Link key={i.id} href={route('empresas.show', i.id)} className="w-fit">
                                                        <Card className="w-fit hover:bg-secondary transition ">
                                                            <CardHeader className="p-4 font-medium">
                                                                <div className="flex items-center gap-1">
                                                                    <Building className="h-4 mr-2" />
                                                                    {i.nombre}
                                                                </div>
                                                                <CardDescription>
                                                                    <span className="font-light ms-2">
                                                                        NIF: {i.nif}
                                                                    </span>
                                                                </CardDescription>
                                                            </CardHeader>
                                                        </Card>
                                                    </Link>
                                                )
                                            })}
                                        </AccordionContent>
                                    </AccordionItem>
                                    <Separator />
                                </>
                            )}
                    </Accordion>
                </div>
            </div>
        </ShowLayout>
    )
}
