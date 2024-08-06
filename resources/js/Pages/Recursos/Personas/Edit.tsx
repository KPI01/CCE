import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { Breadcrumbs, Persona } from "@/types";
import {
  formSchema,
  PERFILES,
  TIPOS_ID_NAC,
  CAPACITACIONES,
} from "./formSchema";
import { Form, FormField, FormLabel } from "@/Components/ui/form";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import FormTitle from "@/Components/Forms/FormTitle";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import FormButton from "@/Components/Forms/FormButton";
import { Save, Trash } from "lucide-react";
import { router } from "@inertiajs/react";
import { useToast } from "@/Components/ui/use-toast";
import { CONTAINER_CLASS } from "../utils";

const schema = formSchema;

export default function Edit({ data }: { data: Persona }) {
  const { toast } = useToast();
  schema.safeParse(data);
  if (data.ropo?.caducidad) data.ropo.caducidad = new Date(data.ropo.caducidad);
  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: { ...data },
  });

  function onSubmit(values: z.infer<typeof schema>) {
    const dirty = form.formState.dirtyFields;
    const validation = schema.parse(values);

    const toSend = Object.keys(dirty).reduce(
      (acc, key) => {
        const aux: { [key: string]: any } = validation;
        if (key in aux) {
          acc[key] = aux[key];
        }
        return acc;
      },
      {} as { [key: string]: any },
    );

    if (Object.keys(toSend).length > 0) {
      router.put(data.urls.update, toSend);
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
      text: "Tabla",
      url: data.urls.index,
    },
    {
      text: "Persona",
      url: data.urls.show,
    },
    {
      text: "Editando...",
      url: data.urls.edit,
    },
  ];

  return (
    <FormLayout
      pageTitle="Persona"
      mainTitle="Editando..."
      created_at={data.created_at}
      updated_at={data.updated_at}
      id={data.id}
      urls={data.urls}
      showActions={false}
      breadcrumbs={breadcrumb}
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
              name="nombres"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Nombres"
                  name={field.name}
                  value={field.value || undefined}
                  autoComplete={"given-name"}
                  onChange={field.onChange}
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
                  value={field.value || undefined}
                  autoComplete={"family-name"}
                  onChange={field.onChange}
                />
              )}
            />

            <div
              className="grid items-center"
              style={{ gridTemplateColumns: "15ch auto 1fr" }}
            >
              <FormLabel
                id="label-id_nac"
                className={
                  form.getFieldState("id_nac").invalid ? "text-destructive" : ""
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
                    value={field.value}
                    onChange={field.onChange}
                    options={TIPOS_ID_NAC}
                    TriggerClass="w-full ml-2"
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
                    autoComplete="off"
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
                  value={field.value}
                  autoComplete={"email"}
                  onChange={field.onChange}
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
                  value={field.value || ""}
                  autoComplete={"tel"}
                  onChange={field.onChange}
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
                  value={field.value || ""}
                  onChange={field.onChange}
                  options={PERFILES}
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
                  value={field.value || ""}
                  onChange={field.onChange}
                  autoComplete="off"
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
                  label="Tipo de carnet"
                  name={field.name}
                  value={field.value || ""}
                  onChange={field.onChange}
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
                  label="N° de carnet"
                  name={field.name}
                  value={field.value || ""}
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
                  triggerClass="w-full mt-0"
                  id={field.name}
                  label="Fecha de caducidad"
                  name={field.name}
                  value={field.value || null}
                  onChange={field.onChange}
                />
              )}
            />
          </div>

          <div className="col-span-full mt-4 flex justify-end gap-x-6">
            <FormButton
              type="reset"
              variant={"destructive"}
              onClick={() => router.delete(data.urls.destroy)}
            >
              <Trash className="mr-2 size-4" />
              Eliminar
            </FormButton>
            <FormButton type="submit">
              <Save className="mr-2 size-4" />
              Guardar
            </FormButton>
          </div>
        </form>
      </Form>
    </FormLayout>
  );
}
