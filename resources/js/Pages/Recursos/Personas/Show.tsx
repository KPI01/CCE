import { Input } from "@/Components/ui/input"
import { Label } from "@/Components/ui/label"
import { Textarea } from "@/Components/ui/textarea"
import ShowLayout from "@/Layouts/Recursos/ShowLayout"
import { LayoutProps } from "@/types"
import { formSchema, PERFILES, TIPOS_APLICADOR, TIPOS_ROPO, TIPOS_ID_NAC } from "./formSchema"
import { useForm } from "react-hook-form"
import { zodResolver } from "@hookform/resolvers/zod"
import { z } from "zod"
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from "@/Components/ui/form"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select"

import { format } from "date-fns"
import FormItemConstructor from "@/Components/Forms/FormItemConstructor"


const CONTAINER_CLASS = "container grid grid-cols-[repeat(2,minmax(250px,1fr))] gap-x-12 gap-y-4 py-4"


const schema = formSchema

interface Props extends LayoutProps {
    data: any
}

export default function Show({
    data
}: Props) {
    // const values = schema.parse(data)
    console.log(data)
    const form = useForm<z.infer<typeof schema>>({
        resolver: zodResolver(schema),
        defaultValues: data
    })

    // let relations = {
    //     empresas: data.empresas ?? undefined
    // }

    return (
        <ShowLayout
            pageTitle="Persona"
            mainTitle={`${data.nombres} ${data.apellidos}`}
            updated_at={data.updated_at}
            recurso="personas"
        >
            <Form {...form}>
                <form id="create-persona-form" className={CONTAINER_CLASS}>
                    <FormField
                        control={form.control}
                        name="nombres"
                        render={({ field }) => (
                           <FormItemConstructor
                            id={field.name}
                            label="Nombres"
                            name={field.name}
                            onChange={field.onChange}
                            value={field.value}
                           />
                        )} />
                    <FormField
                        control={form.control}
                        name="apellidos"
                        render={({ field }) => (
                           <FormItemConstructor
                            id={field.name}
                            label="Apellidos"
                            name={field.name}
                            onChange={field.onChange}
                            value={field.value}
                           />
                        )} />
                    <div className="grid gap-x-6 grid-cols-[10ch_1fr] ">
                        <FormLabel className={'col-span-2' + (form.getFieldState('id_nac').invalid ? ' text-destructive' : '')} htmlFor="id_nac">Identificación</FormLabel>
                        <FormField
                            control={form.control}
                            name="tipo_id_nac"
                            render={({ field }) => (
                                <FormItem>
                                    <Select defaultValue={field.value} name={field.name} disabled>
                                        <FormControl>
                                            <SelectTrigger className="w-full">
                                                <SelectValue placeholder='Selecciona el tipo de identificación' />
                                            </SelectTrigger>
                                        </FormControl>
                                        <SelectContent>
                                            {TIPOS_ID_NAC.map((tipo_id_nac) => (
                                                <SelectItem key={tipo_id_nac} value={tipo_id_nac}>
                                                    {tipo_id_nac}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                    <FormMessage id={`${field.name}-message`} />
                                </FormItem>
                            )} />
                        <FormField
                            control={form.control}
                            name="id_nac"
                            render={({ field }) => (
                                <FormItem className="basis-full">
                                    <FormControl>
                                        <Input
                                            id="id_nac"
                                            disabled
                                            {...field}
                                        />
                                    </FormControl>
                                    <FormMessage id={`${field.name}-message`} />
                                </FormItem>
                            )} />
                    </div>
                    <FormField
                        control={form.control}
                        name="email"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor={field.name}>Correo</FormLabel>
                                <FormControl>
                                    <Input
                                        id="email"
                                        disabled
                                        {...field}
                                    />
                                </FormControl>
                                <FormMessage id={`${field.name}-message`} />
                            </FormItem>
                        )} />
                    <FormField
                        control={form.control}
                        name="tel"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor={field.name}>Teléfono</FormLabel>
                                <FormControl>
                                    <Input
                                        id="tel"
                                        disabled
                                        {...field}
                                    />
                                </FormControl>
                                <FormMessage id={`${field.name}-message`} />
                            </FormItem>
                        )} />
                    <FormField
                        control={form.control}
                        name="perfil"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor={field.name}>Perfil</FormLabel>
                                <FormControl>
                                    <Select name={field.name} defaultValue={field.value} disabled>
                                        <FormControl>
                                            <SelectTrigger
                                                id="perfil"
                                                className="w-full">
                                                <SelectValue placeholder='Selecciona el perfil' />
                                            </SelectTrigger>
                                        </FormControl>
                                        <SelectContent>
                                            {PERFILES.map((perfil) => (
                                                <SelectItem key={perfil} value={perfil}>
                                                    {perfil}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage id={`${field.name}-message`} />
                            </FormItem>
                        )} />
                    <FormField
                        control={form.control}
                        name="observaciones"
                        render={({ field }) => (
                            <FormItem className="col-span-2">
                                <FormLabel htmlFor={field.name}>Observaciones</FormLabel>
                                <FormControl>
                                    <Textarea
                                        id="observaciones"
                                        disabled
                                        {...field}
                                    />
                                </FormControl>
                                <FormMessage id={`${field.name}-message`} />
                            </FormItem>
                        )} />
                    <div id="ropo-form" className='col-span-2 grid grid-cols-[repeat(2,25vw)] place-content-start gap-x-12 gap-y-4'>
                        <FormField
                            control={form.control}
                            name="ropo.tipo"
                            render={({ field }) => (
                                <FormItem>
                                    <FormLabel htmlFor={field.name.replace('.', '-')}>Tipo Carnet</FormLabel>
                                    <FormControl>
                                        <Select name={field.name} defaultValue={field.value} disabled>
                                            <FormControl id={field.name.replace('.', '-')}>
                                                <SelectTrigger className="w-full">
                                                    <SelectValue placeholder='Selecciona el tipo de carnet' />
                                                </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                {TIPOS_ROPO.map((ropo) => (
                                                    <SelectItem key={ropo} value={ropo}>
                                                        {ropo}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                    </FormControl>
                                    <FormMessage id={`${field.name.replace('.', '_')}-message`} />
                                </FormItem>
                            )} />
                        <FormField
                            control={form.control}
                            name="ropo.nro"
                            render={({ field }) => (
                                <FormItem>
                                    <FormLabel htmlFor={field.name.replace('.', '-')}>Nº</FormLabel>
                                    <FormControl id={field.name}>
                                        <Input
                                            id="ropo-nro"
                                            disabled
                                            {...field}
                                        />
                                    </FormControl>
                                    <FormMessage id={`${field.name.replace('.', '_')}-message`} />
                                </FormItem>
                            )}
                        />
                        <FormField
                            control={form.control}
                            name="ropo.caducidad"
                            render={({ field }) => (
                                <FormItem className="flex flex-col">
                                    <FormLabel>
                                            Caducidad del carnet
                                    </FormLabel>
                                    <FormControl>
                                        <Input
                                            id="ropo-caducidad"
                                            disabled
                                            value={field.value ? format(field.value, 'dd/MM/yyyy') : ''}
                                        />
                                    </FormControl>
                                    <FormMessage id={`${field.name.replace('.', '_')}-message`} />
                                </FormItem>
                            )}
                        />
                        <FormField
                            control={form.control}
                            name="ropo.tipo_aplicador"
                            render={({ field }) => (
                                <FormItem>
                                    <FormLabel htmlFor="ropo-tipo_aplicador">Perfil</FormLabel>
                                    <FormControl >
                                        <Select name="ropo.tipo_aplicador" defaultValue={field.value} disabled>
                                            <FormControl>
                                                <SelectTrigger id="ropo-tipo_aplicador" className="w-full">
                                                    <SelectValue placeholder='Selecciona el perfil de aplicador' />
                                                </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                {TIPOS_APLICADOR.map((val) => {
                                                    if (val !== '') {
                                                        return (
                                                            <SelectItem key={TIPOS_APLICADOR.indexOf(val)} value={val}>
                                                                {val}
                                                            </SelectItem>

                                                        )
                                                    }
                                                })}
                                            </SelectContent>
                                        </Select>
                                    </FormControl>
                                    <FormMessage id={`${field.name}-message`} />
                                </FormItem>
                            )} />
                    </div>
                </form>
            </Form>
        </ShowLayout>
    )
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
