"use client"

import CreateLayout from "@/Layouts/Recursos/CreateLayout";

import { z } from 'zod'
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form"
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage
} from '@/Components/ui/form'
import {
    Select,
    SelectContent,
    SelectTrigger,
    SelectValue
} from "@/Components/ui/select";
import { SelectItem } from "@/Components/ui/select";
import { Textarea } from "@/Components/ui/textarea";
import {
    CalendarIcon,
    CheckCircledIcon,
    TrashIcon
} from "@radix-ui/react-icons";
import {
    Popover,
    PopoverTrigger,
    PopoverContent
} from "@/Components/ui/popover";
import { es } from 'date-fns/locale'
import { Calendar } from "@/Components/ui/calendar";
import { router } from "@inertiajs/react";
import { Switch } from "@/Components/ui/switch";
import { Label } from "@/Components/ui/label";
import { useState } from "react";

const RSRC = 'persona'
const REQUIRED_MSG = 'Este campo es requerido.'
const CONTAINER_CLASS = "grid grid-cols-[repeat(2,minmax(250px,1fr))] gap-x-12 gap-y-4"
const TODAY = new Date()
const TODAY_FORMATTED = `${TODAY.getFullYear()}-${(TODAY.getMonth() + 1).toString().padStart(2, '0')}-${TODAY.getDate().toString().padStart(2, '0')}`
const TIPOS_ID_NAC = ['DNI', 'NIE'] as const
const PERFILES = ['Aplicador', 'Técnico', 'Supervisor', 'Productor'] as const
const TIPOS_ROPO = ['Aplicador', 'Técnico'] as const
const TIPOS_APLICADOR = ['', 'Básico', 'Cualificado', 'Fumigación', 'Piloto', 'Aplicación Fitosanitarios'] as const

const formSchema = z.object({
    nombres: z.string({
        required_error: REQUIRED_MSG,
    })
        .min(3, 'El nombre debe tener al menos 3 caracteres.')
        .max(50, 'El nombre debe tener menos de 50 caracteres.'),
    apellidos: z.string({
        required_error: REQUIRED_MSG,
    })
        .min(3, 'Los apellidos deben tener al menos 3 caracteres.')
        .max(50, 'Los apellidos deben tener menos de 50 caracteres.'),
    tipo_id_nac: z.enum(TIPOS_ID_NAC),
    id_nac: z.string({
        required_error: REQUIRED_MSG,
    })
    .max(12, 'El DNI/NIE debe ser de 12 caracteres.'),
    email: z.string({
        required_error: REQUIRED_MSG,
    })
        .email('El correo debe ser válido.'),
    tel: z.string().max(20).optional(),
    perfil: z.enum(PERFILES).optional(),
    observaciones: z.string()
        .max(300, 'Las observaciones deben tener menos de 300 caracteres.')
        .optional(),
    ropo: z.object({
        tipo: z.enum(TIPOS_ROPO).optional(),
        caducidad: z.date().optional(),
        nro: z.string().max(20).optional(),
        tipo_aplicador: z.enum(TIPOS_APLICADOR).optional(),
    }).optional(),
})
    .superRefine((data, ctx) => {
        let tipo_id = data.tipo_id_nac
        let id = data.id_nac
        let regex

        if (tipo_id === 'DNI') {
            regex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]{1}$/
        } else if (tipo_id === 'NIE') {
            regex = /^[XYZ]{1}[0-9]{7}[XYZ]{1}$/
        }

        if (!regex?.test(id)) {
            ctx.addIssue({
                code: z.ZodIssueCode.custom,
                message: 'La identificación debe tener el formato adecuado.',
                path: ['id_nac'],
            })
        }


    })

export default function Create() {
    const [fillRopo, setFillRopo] = useState<boolean>(false)

    const form = useForm<z.infer<typeof formSchema>>({
        resolver: zodResolver(formSchema),
        defaultValues: {
            tipo_id_nac: 'DNI',
        }
    })

    function handleRopoShow(curr: boolean) {
        let val = !curr
        // console.log('¿Mostrando ROPO?:', curr)
        // console.log('Próximo valor:', val)

        setFillRopo(val)
    }

    function onSubmit(values: z.infer<typeof formSchema>) {
        console.log(values)

        router.post(route('personas.store'), values)
    }

    return (
        <CreateLayout rsrc={RSRC}>
            <Form {...form}>
                <form id="create-persona-form" className={CONTAINER_CLASS} onSubmit={form.handleSubmit(onSubmit)}>
                    <FormField
                        control={form.control}
                        name="nombres"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor="nombres">Nombre(s) *</FormLabel>
                                <FormControl>
                                    <Input
                                        id="nombres"
                                        placeholder="..."
                                        {...field}
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        )} />
                    <FormField
                        control={form.control}
                        name="apellidos"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor="apellidos">Apellido(s) *</FormLabel>
                                <FormControl>
                                    <Input
                                        id="apellidos"
                                        placeholder="..."
                                        {...field}
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        )} />
                    <div className="grid gap-x-6 grid-cols-[10ch_1fr] ">
                        <FormLabel className={'col-span-2' + (form.getFieldState('id_nac').invalid ? ' text-destructive' : '')} htmlFor="id_nac">Identificación *</FormLabel>
                        <FormField
                            control={form.control}
                            name="tipo_id_nac"
                            render={({ field }) => (
                                <FormItem>
                                    <Select onValueChange={field.onChange} defaultValue={field.value} name="tipo_id_nac">
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
                                    <FormMessage />
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
                                            placeholder="..."
                                            {...field}
                                        />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            )} />
                    </div>
                    <FormField
                        control={form.control}
                        name="email"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor="email">Correo *</FormLabel>
                                <FormControl>
                                    <Input
                                        id="email"
                                        autoComplete="email"
                                        placeholder="..."
                                        {...field}
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        )} />
                    <FormField
                        control={form.control}
                        name="tel"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor="tel">Teléfono</FormLabel>
                                <FormControl>
                                    <Input
                                        id="tel"
                                        autoComplete="tel"
                                        type="tel"
                                        pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}"
                                        placeholder="..."
                                        {...field}
                                    />
                                </FormControl>
                                <FormDescription>Formato: 123-456-78-90</FormDescription>
                                <FormMessage />
                            </FormItem>
                        )} />
                    <FormField
                        control={form.control}
                        name="perfil"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor="perfil">Perfil</FormLabel>
                                <FormControl>
                                    <Select name="perfil" onValueChange={field.onChange} defaultValue={field.value}>
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
                                <FormMessage />
                            </FormItem>
                        )} />
                    <FormField
                        control={form.control}
                        name="observaciones"
                        render={({ field }) => (
                            <FormItem className="col-span-2">
                                <FormLabel htmlFor="observaciones">Observaciones</FormLabel>
                                <FormControl>
                                    <Textarea
                                    className="resize-y"
                                        rows={1}
                                        id="observaciones"
                                        placeholder="..."
                                        {...field}
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        )} />
                    <div className="flex items-center space-x-2">
                        <Switch name="ropo" id="ropo" onClick={() => handleRopoShow(fillRopo)} />
                        <Label htmlFor="ropo">¿Datos ROPO?</Label>
                    </div>
                    <div id="ropo-form" className={`col-span-2 grid grid-cols-[repeat(2,25vw)] place-content-start gap-x-12 gap-y-4 ${fillRopo ? '' : 'hidden'}`}>
                        <FormField
                            control={form.control}
                            name="ropo.tipo"
                            render={({ field }) => (
                                <FormItem>
                                    <FormLabel htmlFor="ropo-tipo">Tipo Carnet</FormLabel>
                                    <FormControl>
                                        <Select name="ropo.tipo" onValueChange={field.onChange} defaultValue={field.value}>
                                            <FormControl id="ropo-tipo">
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
                                    <FormMessage />
                                </FormItem>
                            )} />
                        <FormField
                            control={form.control}
                            name="ropo.nro"
                            render={({ field }) => (
                                <FormItem>
                                    <FormLabel htmlFor="ropo-nro">Nº</FormLabel>
                                    <FormControl>
                                        <Input
                                            id="ropo-nro"
                                            placeholder="..."
                                            {...field}
                                        />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            )}
                        />
                        <FormField
                            control={form.control}
                            name="ropo.caducidad"
                            render={({ field }) => (
                                <FormItem className="flex flex-col">
                                    <FormLabel htmlFor="#" asChild>
                                        <span>Fecha de caducidad</span>
                                    </FormLabel>
                                    <Popover>
                                        <FormControl>
                                            <div className="flex items-center gap-2">
                                                <Input
                                                    type="date"
                                                    id="ropo-caducidad_input"
                                                    className="
                                                    "
                                                    placeholder="DD/MM/AAAA"
                                                    pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
                                                    onChange={field.onChange}
                                                />
                                                <PopoverTrigger id="ropo-caducidad_trigger" asChild>
                                                    <Button variant={"outline"} size="sm">
                                                        <CalendarIcon className="opacity-75" />
                                                    </Button>
                                                </PopoverTrigger>
                                            </div>
                                        </FormControl>
                                        <PopoverContent className="w-auto p-0">
                                            <Calendar
                                                id="ropo-caducidad_calendar"
                                                mode="single"
                                                locale={es}
                                                showOutsideDays={false}
                                                captionLayout={"dropdown"}
                                                selected={field.value}
                                                onSelect={field.onChange}
                                                disabled={(date: Date) => date < new Date() || date < new Date("1900-01-01")}
                                                initialFocus

                                            />
                                        </PopoverContent>
                                    </Popover>
                                    <FormDescription>
                                        Formato: DD/MM/AAAA.
                                    </FormDescription>
                                    <FormMessage />
                                </FormItem>
                            )} />
                        <FormField
                            control={form.control}
                            name="ropo.tipo_aplicador"
                            render={({ field }) => (
                                <FormItem>
                                    <FormLabel htmlFor="ropo-tipo_aplicador">Perfil</FormLabel>
                                    <FormControl >
                                        <Select name="ropo.tipo_aplicador" onValueChange={field.onChange} defaultValue={field.value}>
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
                                    <FormMessage />
                                </FormItem>
                            )} />
                    </div>
                    <div className="col-span-2 flex justify-between items-center">
                        <Button variant={'destructive'} className="col-span-2" type="reset">
                            <TrashIcon className="mr-2" />
                            Vaciar
                        </Button>
                        <Button type="submit">
                            <CheckCircledIcon className="mr-2" />
                            Crear
                        </Button>
                    </div>
                </form>
            </Form>
        </CreateLayout >
    )
}
