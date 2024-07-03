import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { LayoutProps, Persona } from "@/types";
import {
  CONTAINER_CLASS,
  formSchema,
  PERFILES,
  TIPOS_APLICADOR,
  TIPOS_ID_NAC,
  TIPOS_ROPO,
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
        tipo: data.ropo?.tipo || "",
        caducidad: data.ropo?.caducidad || null,
        nro: data.ropo?.nro || "",
        tipo_aplicador: data.ropo?.tipo_aplicador || "",
      },
    },
  });

  function onSubmit(formValues: z.infer<typeof schema>) {
    const validation = schema.parse(formValues);

    if (Object.keys(form.formState.dirtyFields).length > 0) {
      router.put(urls.update, validation);
    } else {
      console.warn("Sin cambios!");
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

          <Separator className="col-span-full my-4" />
          <FormTitle id="h3-ropo" title="Datos ROPO" />

          <FormField
            control={form.control}
            name="ropo.tipo"
            render={({ field }) => (
              <FormItemSelectConstructor
                id={field.name}
                label="Tipo de carnet"
                name={field.name}
                value={field.value || ""}
                onChange={field.onChange}
                options={TIPOS_ROPO}
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

          <FormField
            control={form.control}
            name="ropo.tipo_aplicador"
            render={({ field }) => (
              <FormItemSelectConstructor
                id={field.name}
                label="Tipo de aplicador"
                name={field.name}
                value={field.value || ""}
                onChange={field.onChange}
                options={TIPOS_APLICADOR}
              />
            )}
          />

          <div className="flex gap-x-6 justify-end col-span-full mt-4">
            <FormButton
              type="reset"
              variant={"destructive"}
              onClick={() => router.get(urls.show)}
            >
              <CircleX className="size-4 mr-2" />
              Cancelar
            </FormButton>
            <FormButton type="submit">
              <Save className="size-4 mr-2" />
              Guardar
            </FormButton>
          </div>
        </form>
      </Form>
    </FormLayout>
  );
}
