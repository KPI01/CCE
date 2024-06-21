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
import {
    formSchema,
    PERFILES,
    TIPOS_APLICADOR,
    TIPOS_ID_NAC,
    TIPOS_ROPO
} from "./formSchema";
import {FormItemSelectConstructor} from "@/Components/Forms/FormItemSelectConstructor";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";

const RECURSO = 'personas'
const CONTAINER_CLASS = "container grid grid-cols-2 gap-x-32 gap-y-8"

const schema = formSchema

export default function Create() {
    const [fillRopo, setFillRopo] = useState<boolean>(false)

    const form = useForm<z.infer<typeof schema>>({
        resolver: zodResolver(schema),
        defaultValues: {
            tipo_id_nac: 'DNI',
        }
    })
    // console.log(form.formState)

    function handleRopoShow(curr: boolean) {
        let val = !curr
        // console.log('¿Mostrando ROPO?:', curr)
        // console.log('Próximo valor:', val)

        setFillRopo(val)
    }

    function onSubmit(values: z.infer<typeof schema>) {
        console.log(values)

        router.post(route(`${RECURSO}.store`), values)
    }

    return (
        <CreateLayout
            pageTitle={`Creando: ${RECURSO}`}
            mainTitle='Modo creación'
            recurso={RECURSO}
        >
            <Form {...form}>
                <form id="create-persona-form" className={CONTAINER_CLASS} onSubmit={form.handleSubmit(onSubmit)}>
                    <FormField
                        control={form.control}
                        name="nombres"
                        render={({ field }) => (
                            <FormItemConstructor
                                id={field.name}
                                label="Nombre(s) *"
                                name={field.name}
                                placeholder="..."
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
                            label="Apellido(s) *"
                            name={field.name}
                            placeholder="..."
                            onChange={field.onChange}
                            value={field.value}
                            />
                        )} />
                    <div className="grid gap-x-12 grid-cols-[10ch_1fr] ">
                        <FormLabel className={'col-span-2 mb-3' + (form.getFieldState('id_nac').invalid ? ' text-destructive' : '')} htmlFor="id_nac">Identificación *</FormLabel>
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
                                <FormItem>
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
                            <FormItemConstructor
                                id={field.name}
                                label="Email"
                                name={field.name}
                                placeholder="..."
                                onChange={field.onChange}
                                value={field.value}
                                />
                        )} />
                    <FormField
                        control={form.control}
                        name="tel"
                        render={({ field }) => (
                            <FormItemConstructor
                                id={field.name}
                                label="Teléfono"
                                name={field.name}
                                placeholder="..."
                                onChange={field.onChange}
                                value={field.value}
                                />
                        )} />
                    <FormField
                        control={form.control}
                        name="perfil"
                        render={({ field }) => (
                            <FormItemSelectConstructor
                                id={field.name}
                                name={field.name}
                                label="Perfil"
                                value={field.value as string}
                                placeholder="Seleccionar perfil..."
                                onChange={field.onChange}
                                options={PERFILES}
                            />
                        )} />
                    <FormField
                        control={form.control}
                        name="observaciones"
                        render={({ field }) => (
                            <FormItemConstructor
                                id={field.name}
                                label="Observaciones"
                                textarea
                                name={field.name}
                                placeholder="..."
                                onChange={field.onChange}
                                value={field.value}
                                />
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
                                <FormItemSelectConstructor
                                    id={field.name}
                                    name={field.name}
                                    label="Tipo de ROPO"
                                    value={field.value as string}
                                    placeholder="Seleccionar tipo..."
                                    onChange={field.onChange}
                                    options={TIPOS_ROPO}
                                    />
                            )} />
                        <FormField
                            control={form.control}
                            name="ropo.nro"
                            render={({ field }) => (
                                <FormItemConstructor
                                    id={field.name}
                                    label="Nº Carnet"
                                    name={field.name}
                                    placeholder="..."
                                    onChange={field.onChange}
                                    value={field.value}
                                    />
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
                                <FormItemSelectConstructor
                                    id={field.name}
                                    label="Tipo de aplicador"
                                    options={TIPOS_APLICADOR}
                                    value={field.value as string}
                                    onChange={field.onChange}
                                    name={field.name}
                                    placeholder="Selecciona el tipo de aplicador"
                                />
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
