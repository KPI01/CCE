import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { LayoutProps, Persona } from "@/types";
import {
  CONTAINER_CLASS,
  formSchema,
  PERFILES,
  TIPOS_ID_NAC,
  CAPACITACIONES,
} from "./formSchema";
import { Form, FormField, FormLabel } from "@/Components/ui/form";
import { Separator } from "@/Components/ui/separator";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import FormTitle from "@/Components/Forms/FormTitle";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import FormButton from "@/Components/Forms/FormButton";
import { CircleX, Save } from "lucide-react";
import { router } from "@inertiajs/react";
import { useToast } from "@/Components/ui/use-toast";

const schema = formSchema;

interface Props extends LayoutProps {
  data: Persona;
  urls: {
    update: string;
    show: string;
  };
}
export default function Edit({ data, urls }: Props) {
  const { toast } = useToast();

  data.created_at = new Date(data.created_at);
  data.updated_at = new Date(data.updated_at);
  if (data.ropo?.caducidad) data.ropo.caducidad = new Date(data.ropo.caducidad);

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
        capacitacion: data.ropo?.capacitacion || null,
        caducidad: data.ropo?.caducidad || null,
        nro: data.ropo?.nro || null,
      },
    },
  });

  function onSubmit(values: z.infer<typeof schema>) {
    console.debug(values);
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
      router.put(urls.update, toSend);
    } else {
      toast({
        title: "No se han detectado cambios!",
        variant: "muted",
        customId: "edit-sin_cambios",
      });
    }
  }

  return (
    <FormLayout
      pageTitle="Persona"
      mainTitle="Editando..."
      created_at={data.created_at.toLocaleString()}
      updated_at={data.updated_at.toLocaleString()}
      backUrl={urls.show}
    >
      <Form {...form}>
        <form
          id={`edit-form-${data.id}`}
          onSubmit={form.handleSubmit(onSubmit)}
          className={CONTAINER_CLASS}
        >
          <div className="space-y-4">
            <FormTitle id="h3-datos_personales" title="Datos Personales" />
            <FormField
              control={form.control}
              name="nombres"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Nombres"
                  name={field.name}
                  value={field.value}
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
                  value={field.value}
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
                  value={field.value}
                  autoComplete={"tel"}
                  onChange={field.onChange}
                  descripcion="Formato: 123-45-67-89"
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
                  value={field.value}
                  onChange={field.onChange}
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
              onClick={() => router.get(urls.show)}
            >
              <CircleX className="mr-2 size-4" />
              Cancelar
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
