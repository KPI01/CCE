import { LayoutProps, Persona, Urls } from "@/types";
import {
  formSchema,
  PERFILES,
  TIPOS_APLICADOR,
  TIPOS_ROPO,
  TIPOS_ID_NAC,
  CONTAINER_CLASS,
} from "./formSchema";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { Form, FormField, FormLabel } from "@/Components/ui/form";

import { format } from "date-fns";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import FormTitle from "@/Components/Forms/FormTitle";

const schema = formSchema;

interface Props extends LayoutProps {
  data: Persona;
  urls: Urls;
}

export default function Show({ data, urls }: Props) {
  console.debug(data);
  console.debug(urls);

  data.created_at = new Date(data.created_at);
  data.updated_at = new Date(data.updated_at);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: {
      nombres: data.nombres,
      apellidos: data.apellidos,
      tipo_id_nac: data.tipo_id_nac,
      id_nac: data.id_nac,
      email: data.email,
      tel: data.tel || "",
      perfil: data.perfil || "",
      observaciones: data.observaciones || "",
      ropo: {
        tipo: data.ropo?.tipo || "",
        caducidad: data.ropo?.caducidad
          ? new Date(data.ropo.caducidad)
          : undefined,
        nro: data.ropo?.nro || "",
        tipo_aplicador: data.ropo?.tipo_aplicador || "",
      },
    },
  });

  return (
    <FormLayout
      id={data.id}
      pageTitle="Persona"
      mainTitle={`${data.nombres} ${data.apellidos}`}
      created_at={data.created_at.toLocaleString()}
      updated_at={data.updated_at.toLocaleString()}
      urls={urls}
      backUrl={urls.index}
    >
      <Form {...form}>
        <form id={`show-form-${data.id}`} className={CONTAINER_CLASS}>
          <FormTitle id="h3-basicos" title="Datos básicos" />
          <div
            className="grid items-center"
            style={{ gridTemplateColumns: "15ch auto 1fr" }}
          >
            <FormLabel
              id="label-id_nac"
              className={
                form.getFieldState("id_nac").invalid ? " text-destructive" : ""
              }
              htmlFor="input-id_nac"
            >
              Identificación
            </FormLabel>
            <FormField
              control={form.control}
              name="tipo_id_nac"
              render={({ field }) => (
                <FormItemSelectConstructor
                  id={field.name}
                  name={field.name}
                  label="Tipo de identificación"
                  withLabel={false}
                  value={field.value || ""}
                  placeholder="..."
                  onChange={field.onChange}
                  options={TIPOS_ID_NAC}
                  TriggerClass="w-full ml-2"
                  disabled
                />
              )}
            />
            <FormField
              control={form.control}
              name="id_nac"
              render={({ field }) => (
                <FormItemConstructor
                  withLabel={false}
                  id={field.name}
                  label="Identificación"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  itemClass="ml-3"
                  inputClass="col-span-2"
                  disabled
                />
              )}
            />
          </div>
          <FormField
            control={form.control}
            name="email"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Email"
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                disabled
              />
            )}
          />
          <FormField
            control={form.control}
            name="tel"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Teléfono"
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                disabled
              />
            )}
          />
          <FormField
            control={form.control}
            name="perfil"
            render={({ field }) => (
              <FormItemSelectConstructor
                id={field.name}
                name={field.name}
                label="Perfil"
                value={field.value as string}
                placeholder="..."
                onChange={field.onChange}
                options={PERFILES}
                disabled
              />
            )}
          />
          <FormField
            control={form.control}
            name="observaciones"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Observaciones"
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                disabled
                textarea
              />
            )}
          />

          <FormTitle id="h3-ropo" title="Datos ROPO" />
          <div
            id="ropo-form"
            className="col-span-2 grid grid-cols-2 gap-x-12 gap-y-4"
          >
            <FormField
              control={form.control}
              name="ropo.tipo"
              render={({ field }) => (
                <FormItemSelectConstructor
                  id={field.name}
                  name={field.name}
                  label="Tipo de carnet"
                  value={field.value as string}
                  placeholder="No posee"
                  onChange={field.onChange}
                  options={TIPOS_ROPO}
                  disabled
                />
              )}
            />

            <FormField
              control={form.control}
              name="ropo.nro"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  name={field.name}
                  placeholder="No posee"
                  value={field.value}
                  onChange={field.onChange}
                  label="N° de carnet"
                  disabled
                />
              )}
            />

            <FormField
              control={form.control}
              name="ropo.caducidad"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  name={field.name}
                  placeholder="No posee"
                  value={field.value ? format(field.value, "dd/MM/yyyy") : ""}
                  onChange={field.onChange}
                  label="Caducidad"
                  disabled
                />
              )}
            />

            <FormField
              control={form.control}
              name="ropo.tipo_aplicador"
              render={({ field }) => (
                <FormItemSelectConstructor
                  id={field.name}
                  name={field.name}
                  placeholder="No posee"
                  value={field.value || ""}
                  onChange={field.onChange}
                  label="Tipo de aplicador"
                  options={TIPOS_APLICADOR}
                  disabled
                />
              )}
            />
          </div>
        </form>
      </Form>
    </FormLayout>
  );
}
