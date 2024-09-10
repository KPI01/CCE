import { useForm } from "react-hook-form";
import { CAPACITACIONES, formSchema, PERFILES } from "./formSchema";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { Breadcrumbs, Empresa } from "@/types";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import { Form, FormField } from "@/Components/ui/form";
import FormTitle from "@/Components/Forms/FormTitle";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import { router } from "@inertiajs/react";
import { useToast } from "@/Components/ui/use-toast";
import {
  CONTAINER_CLASS,
  EditIcon,
  EmpresaIcon,
  nullToUndefined,
  TablaIcon,
  toSend,
  urlWithoutId,
} from "../utils";
import { EditButtons } from "@/Components/Forms/Footers";

const schema = formSchema;

export default function Edit({ data }: { data: Empresa }) {
  data = nullToUndefined(data);
  const { toast } = useToast();

  if (data.ropo?.caducidad)
    data.ropo.caducidad = new Date(data.ropo?.caducidad);

  const parsed = schema.safeParse(data);
  console.debug(parsed);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: { ...data },
  });

  function handleDelete(): void {
    console.debug(`Eliminando ${data.id}...`);
    router.delete(data.url);
  }

  function onSubmit(values: z.infer<typeof schema>): void {
    const dirty = form.formState.dirtyFields;
    const parsed = schema.parse(values);
    console.debug("Enviando formulario...");
    console.debug(parsed);

    const justDirty = toSend(dirty, parsed);

    if (Object.keys(justDirty).length > 0) {
      router.patch(data.url, justDirty);
    } else {
      toast({
        title: "No se han detectado cambios!",
        variant: "muted",
        customId: "edit-sin_cambios",
      });
    }
  }

  const breadcrumb: Breadcrumbs[] = [
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
    {
      icon: <EditIcon />,
      text: "Editando...",
      url: `${data.url}/edit`,
    },
  ];

  return (
    <FormLayout
      pageTitle="Empresa"
      mainTitle="Editando..."
      created_at={data.updated_at}
      updated_at={data.updated_at}
      id={data.id}
      url={data.url}
      breadcrumbs={breadcrumb}
      showActions={false}
    >
      <Form {...form}>
        <form
          id={`edit-${data.id}`}
          onSubmit={form.handleSubmit(onSubmit)}
          className={CONTAINER_CLASS}
        >
          <div className="space-y-4">
            <FormTitle id="h3-generales" title="Información Básica" />
            <FormField
              control={form.control}
              name="nombre"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Nombre"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  autoComplete={"organization"}
                />
              )}
            />
            <FormField
              control={form.control}
              name="nif"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="NIF"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  autoComplete="off"
                />
              )}
            />
            <FormField
              control={form.control}
              name="email"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Correo"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  autoComplete="email"
                />
              )}
            />
            <FormField
              control={form.control}
              name="perfil"
              render={({ field }) => (
                <FormItemSelectConstructor
                  id={field.name}
                  label="Perfil"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || PERFILES[0]}
                  options={PERFILES}
                />
              )}
            />
            <FormField
              control={form.control}
              name="tel"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Teléfono"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  autoComplete="tel"
                />
              )}
            />
            <FormField
              control={form.control}
              name="direccion"
              render={({ field }) => (
                <FormItemConstructor
                  textarea
                  id={field.name}
                  label="Dirección"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  autoComplete="street-address"
                />
              )}
            />

            <FormField
              control={form.control}
              name="codigo"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Código"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  autoComplete="off"
                />
              )}
            />
            <FormField
              control={form.control}
              name="observaciones"
              render={({ field }) => (
                <FormItemConstructor
                  textarea
                  id={field.name}
                  label="Observaciones"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                />
              )}
            />
          </div>
          <div className="space-y-4">
            <FormTitle id="h3-ropo" title="Datos ROPO" />
            <FormField
              control={form.control}
              name="ropo.capacitacion"
              render={({ field }) => (
                <FormItemSelectConstructor
                  id={field.name}
                  label="Capacitación"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || CAPACITACIONES[0]}
                  options={CAPACITACIONES}
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
                  label="Identificación"
                  value={field.value}
                  onChange={field.onChange}
                  autoComplete="off"
                />
              )}
            />
            <FormField
              control={form.control}
              name="ropo.caducidad"
              render={({ field }) => (
                <FormDatePickerConstructor
                  id={field.name}
                  name={field.name}
                  label="Caducidad"
                  value={field.value}
                  onChange={field.onChange}
                />
              )}
            />
          </div>
          <EditButtons destroyCallback={handleDelete} />
        </form>
      </Form>
    </FormLayout>
  );
}
