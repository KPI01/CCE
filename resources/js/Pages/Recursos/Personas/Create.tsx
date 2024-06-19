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
import { format } from "date-fns";
import { cn } from "@/lib/utils";
import { Save, Trash2, CalendarDays } from "lucide-react";

const RSRC = 'personas'
const REQUIRED_MSG = 'Este campo es requerido.'
const CONTAINER_CLASS = "grid grid-cols-[repeat(2,minmax(250px,1fr))] gap-x-12 gap-y-4"
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
    tel: z.string()
        .regex(/^[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}$/, 'El número debe estar en el formato indicado.')
        .optional(),
    perfil: z.enum(PERFILES)
        .optional(),
    observaciones: z.string()
        .max(300, 'Las observaciones deben tener menos de 300 caracteres.')
        .optional(),
    ropo: z.object({
        tipo: z.enum(TIPOS_ROPO).optional(),
        caducidad: z.date().optional(),
        nro: z.string().optional(),
        tipo_aplicador: z.enum(TIPOS_APLICADOR).optional(),
    })
        .optional()
        .superRefine((data, ctx) => {
            if (data?.tipo && !data?.nro) {
                console.log('')
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    message: 'Debes ingresar el Nº del carnet.',
                    path: ['nro'],
                })
            } else if (!data?.tipo && data?.nro) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    message: 'Debes seleccionar el tipo de carnet.',
                    path: ['tipo'],
                })
            } else if (data?.tipo && data?.nro) {
                const regex = /^[0-9]{5,}[A-Z]{2}[/]?[0-9]*$|^[0-9]{1,3}[/][0-9]{1,3}$/gm;

                if (!regex.test(data.nro)) {
                    ctx.addIssue({
                        code: z.ZodIssueCode.custom,
                        message: 'El Nº del carnet debe estar en el formato adecuado.',
                        path: ['nro'],
                    })
                }
            } else if (!data?.tipo && !data?.nro) {
                return true
            }
        })
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
    console.log(form.formState)

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
                                <FormLabel htmlFor={field.name}>Nombre(s) *</FormLabel>
                                <FormControl>
                                    <Input
                                        id="nombres"
                                        name={field.name}
                                        placeholder="..."
                                        onChange={field.onChange}
                                    />
                                </FormControl>
                                <FormMessage id={`${field.name}-message`} />
                            </FormItem>
                        )} />
                    <FormField
                        control={form.control}
                        name="apellidos"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel htmlFor={field.name}>Apellido(s) *</FormLabel>
                                <FormControl>
                                    <Input
                                        id="apellidos"
                                        name={field.name}
                                        placeholder="..."
                                        onChange={field.onChange}
                                    />
                                </FormControl>
                                <FormMessage id={`${field.name}-message`} />
                            </FormItem>
                        )} />
                    <div className="grid gap-x-6 grid-cols-[10ch_1fr] ">
                        <FormLabel className={'col-span-2' + (form.getFieldState('id_nac').invalid ? ' text-destructive' : '')} htmlFor="id_nac">Identificación *</FormLabel>
                        <FormField
                            control={form.control}
                            name="tipo_id_nac"
                            render={({ field }) => (
                                <FormItem>
                                    <Select onValueChange={field.onChange} defaultValue={field.value} name={field.name}>
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
                                            name={field.name}
                                            placeholder="..."
                                            onChange={field.onChange}
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
                                <FormLabel htmlFor={field.name}>Correo *</FormLabel>
                                <FormControl>
                                    <Input
                                        id="email"
                                        name={field.name}
                                        autoComplete="email"
                                        placeholder="..."
                                        onChange={field.onChange}
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
                                        name={field.name}
                                        autoComplete="tel"
                                        type="tel"
                                        placeholder="..."
                                        onChange={field.onChange}
                                    />
                                </FormControl>
                                <FormDescription>Formato: 123-45-67-89</FormDescription>
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
                                    <Select name={field.name} onValueChange={field.onChange} defaultValue={field.value}>
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
                                        name={field.name}
                                        className="resize-y"
                                        rows={1}
                                        placeholder="..."
                                        onChange={field.onChange}
                                    />
                                </FormControl>
                                <FormMessage id={`${field.name}-message`} />
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
                                    <FormLabel htmlFor={field.name.replace('.', '-')}>Tipo Carnet</FormLabel>
                                    <FormControl>
                                        <Select name={field.name} onValueChange={field.onChange} defaultValue={field.value}>
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
                                            name={field.name}
                                            placeholder="..."
                                            onChange={field.onChange}
                                            value={field.value || ''}
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
                                    <FormLabel asChild>
                                        <span>
                                            Caducidad del carnet
                                        </span>
                                    </FormLabel>
                                    <Popover>
                                        <PopoverTrigger id={`${field.name.replace('.', '_')}-trigger`} asChild>
                                            <FormControl>
                                                <Button
                                                    variant={"outline"}
                                                    className={cn(
                                                        "w-[240px] pl-3 text-left font-normal",
                                                        !field.value && "text-muted-foreground"
                                                    )}
                                                    value={
                                                        field.value ?
                                                            format(field.value, "dd/MM/yyyy")
                                                            : "dd/mm/aaaa"
                                                    }
                                                >
                                                    <span id={`${field.name.replace('.', '_')}-value`}>
                                                        {field.value ? (
                                                            format(field.value, "dd/MM/yyyy")
                                                        ) : (
                                                            "dd/mm/aaaa"
                                                        )}
                                                    </span>
                                                    <Input
                                                        id={`${field.name.replace('.', '_')}-input`}
                                                        type="hidden"
                                                        name={field.name}
                                                        value={
                                                            field.value ? format(field.value, "yyyy-MM-dd") : ""
                                                        }
                                                        onChange={field.onChange} />
                                                    <CalendarDays className="ml-auto h-4 w-4 opacity-50" />
                                                </Button>
                                            </FormControl>
                                        </PopoverTrigger>
                                        <PopoverContent className="w-auto p-0" align="start">
                                            <Calendar
                                                id={`${field.name.replace('.', '_')}-calendar`}
                                                mode="single"
                                                locale={es}
                                                selected={field.value}
                                                onSelect={field.onChange}
                                                disabled={(date) =>
                                                    date < new Date()
                                                }
                                                initialFocus
                                            />
                                        </PopoverContent>
                                    </Popover>
                                    <FormDescription>
                                        Utiliza el calendario para ingresar la fecha.
                                    </FormDescription>
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
                                    <FormMessage id={`${field.name}-message`} />
                                </FormItem>
                            )} />
                    </div>
                    <div className="col-span-2 flex justify-between items-center">
                        <Button variant={'destructive'} className="col-span-2" type="reset">
                            <Trash2 className="mr-2 h-4" />
                            Vaciar
                        </Button>
                        <Button type="submit">
                            <Save className="h-4 mr-2" />
                            Crear
                        </Button>
                    </div>
                </form>
            </Form>
        </CreateLayout >
    )
}
