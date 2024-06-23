import { ControllerRenderProps, useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";

import EditLayout from "@/Layouts/Recursos/EditLayout";
import { LayoutProps, Persona } from "@/types";
import {
    formSchema,
    PERFILES,
    TIPOS_ID_NAC,
} from "./formSchema";
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from "@/Components/ui/form";
import { Input } from "@/Components/ui/input";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select";
import { useState } from "react";


const RECURSO = 'personas'

const schema = formSchema

interface Props extends LayoutProps {
    data: Persona
}

export default function Edit({
    data
}: Props) {
    const form = useForm<z.infer<typeof schema>>({
        resolver: zodResolver(schema),
        defaultValues: {
            nombres: data.nombres,
            apellidos: data.apellidos,
            tipo_id_nac: data.tipo_id_nac,
            id_nac: data.id_nac,
            email: data.email,
            tel: data.tel || '',
            perfil: data.perfil || '',
            observaciones: data.observaciones || '',
            ropo: {
                tipo: data.ropo?.tipo || '',
                caducidad: data.ropo?.caducidad || undefined,
                nro: data.ropo?.nro || '',
                tipo_aplicador: data.ropo?.tipo_aplicador || ''
            }
        }
    })
    console.debug('formDefaults:', form.getValues())

    const [values, setValues] = useState<z.infer<typeof schema>>({ ...form.getValues() })
    console.debug('state:', values)

    function handleStateChange(key: keyof z.infer<typeof schema>, newValue: Pick<typeof values, keyof typeof values>) {
        console.debug('handleStateChange | key:', key)
        console.debug(`handleStateChange | newValue[${key}]:`, newValue)

        switch (key) {
            default:
                setValues({ ...values, [key]: newValue })
        }
    }

    function onSubmit(values: z.infer<typeof schema>) {
        console.log(values)
    }

    return (
        <EditLayout
            pageTitle={`Editando: ${RECURSO}`}
            mainTitle='Modo edición'
            recurso={RECURSO}
        >
            <Form {...form}>
                <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-8">
                    <FormField
                        control={form.control}
                        name="nombres"
                        render={({ field }) => (
                            <FormItemConstructor
                                id={field.name}
                                label="Nombres"
                                name={field.name}
                                value={values.nombres}
                                onChange={(e) => handleStateChange('nombres', e.target.value)}
                            />
                        )}
                    />

                    <FormField
                        control={form.control}
                        name="apellidos"
                        render={({ field }) => (
                            <FormItemConstructor
                                id={field.name}
                                label="Apellidos"
                                name={field.name}
                                value={values.apellidos}
                                onChange={(e) => handleStateChange('apellidos', e.target.value)}
                            />
                        )}
                    />

                    <div className="grid gap-x-12 grid-cols-[10ch_1fr] ">
                        <FormLabel className={'col-span-2 mb-3' + (form.getFieldState('id_nac').invalid ? ' text-destructive' : '')} htmlFor="id_nac">Identificación *</FormLabel>
                        <FormField
                            control={form.control}
                            name="tipo_id_nac"
                            render={({ field }) => (
                                <FormItem>
                                    <Select onValueChange={(e: 'DNI' | 'NIE') => handleStateChange('tipo_id_nac', e)} defaultValue={values.tipo_id_nac} name={field.name}>
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
                                            value={values.id_nac}
                                            onChange={(e) => setValues({ ...values, id_nac: e.target.value })}
                                        />
                                    </FormControl>
                                    <FormMessage id={`${field.name}-message`} />
                                </FormItem>
                            )} />
                    </div>

                    <FormField
                        control={form.control}
                        name="perfil"
                        render={({ field }) => (
                            <FormItemSelectConstructor
                                id={field.name}
                                label="Perfil"
                                name={field.name}
                                value={values.perfil}
                                onChange={(e) => setValues({ ...values, perfil: e })}
                                options={PERFILES}
                                placeholder="Selecciona un perfil"
                            />
                        )}
                    />


                </form>
            </Form>
        </EditLayout>
    )
}
