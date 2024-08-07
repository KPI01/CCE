import { Breadcrumbs, Empresa } from "@/types";
import { formSchema, PERFILES, CAPACITACIONES } from "./formSchema";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import FormTitle from "@/Components/Forms/FormTitle";
import { Form, FormField } from "@/Components/ui/form";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import {
  CONTAINER_CLASS,
  EmpresaIcon,
  TablaIcon,
  nullToUndefined,
  urlWithoutId,
} from "../utils";

const schema = formSchema;

export default function Show({ data }: { data: Empresa }) {
  data = nullToUndefined(data);
  schema.safeParse(data);
  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: { ...data },
  });

  const breadcrumbs: Breadcrumbs[] = [
    {
      icon: <TablaIcon />,
      text: "Tabla",
      url: urlWithoutId(data.url),
    },
    {
      icon: <EmpresaIcon />,
      text: "Empresa",
      url: data.url,
    },
  ];

  return (
    <FormLayout
      id={data.id}
      pageTitle={`Empresa: ${data.nombre}`}
      mainTitle={data.nombre}
      created_at={data.created_at}
      updated_at={data.updated_at}
      url={data.url}
      breadcrumbs={breadcrumbs}
    >
      <Form {...form}>
        <form id={`show-${data.id}`} className={CONTAINER_CLASS}>
          <div className="space-y-4">
            <FormTitle title="Información General" id="h3-general" />
            <FormField
              control={form.control}
              name="nif"
              render={({ field }) => (
                <FormItemConstructor
                  label="NIF"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  disabled
                />
              )}
            />
            <FormField
              control={form.control}
              name="email"
              render={({ field }) => (
                <FormItemConstructor
                  label="Correo"
                  id={field.name}
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
                  label="Teléfono"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || ""}
                  disabled
                />
              )}
            />
            <FormField
              control={form.control}
              name="codigo"
              render={({ field }) => (
                <FormItemConstructor
                  label="Código"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || ""}
                  disabled
                />
              )}
            />
            <FormField
              control={form.control}
              name="perfil"
              render={({ field }) => (
                <FormItemSelectConstructor
                  label="Perfil"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || ""}
                  options={PERFILES}
                  disabled
                />
              )}
            />
            <FormField
              control={form.control}
              name="direccion"
              render={({ field }) => (
                <FormItemConstructor
                  textarea
                  inputClass="resize-none"
                  label="Dirección"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || ""}
                  disabled
                />
              )}
            />
            <FormField
              control={form.control}
              name="observaciones"
              render={({ field }) => (
                <FormItemConstructor
                  textarea
                  inputClass="resize-none"
                  label="Observaciones"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || ""}
                  disabled
                />
              )}
            />
          </div>

          <div className="space-y-4">
            <FormTitle title="Datos ROPO" id="h3-ropo" />
            <FormField
              control={form.control}
              name="ropo.capacitacion"
              render={({ field }) => (
                <FormItemSelectConstructor
                  label="Capacitación"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || ""}
                  options={CAPACITACIONES}
                  disabled
                />
              )}
            />
            <FormField
              control={form.control}
              name="ropo.nro"
              render={({ field }) => (
                <FormItemConstructor
                  label="Identificación"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || ""}
                  disabled
                />
              )}
            />
            <FormField
              control={form.control}
              name="ropo.caducidad"
              render={({ field }) => (
                <FormDatePickerConstructor
                  label="Caducidad"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
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
