import { useForm } from "react-hook-form";
import {
  CAPACITACIONES,
  CONTAINER_CLASS,
  formSchema,
  PERFILES,
} from "./formSchema";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { Empresa, Urls } from "@/types";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import { Form, FormField } from "@/Components/ui/form";
import FormTitle from "@/Components/Forms/FormTitle";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormButton from "@/Components/Forms/FormButton";
import { Save } from "lucide-react";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import { router } from "@inertiajs/react";
import { useToast } from "@/Components/ui/use-toast";
import { formatDate } from "@/lib/dates";

const schema = formSchema;

interface Props {
  data: Empresa;
  urls: Required<Pick<Urls, "show" | "update">>;
}

export default function Edit({ data, urls }: Props) {
  const { toast } = useToast();

  const valid = schema.safeParse(data);
  console.debug(valid);

  data.created_at = new Date(data.created_at);
  data.updated_at = new Date(data.updated_at);
  if (data.ropo?.caducidad)
    data.ropo.caducidad = new Date(data.ropo?.caducidad);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: { ...valid.data },
  });

  function onSubmit(values: z.infer<typeof schema>) {
    const dirty = form.formState.dirtyFields;
    const valid = schema.parse(values);

    const toSend = Object.keys(dirty).reduce(
      (acc, key) => {
        const aux: { [key: string]: any } = valid;
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
      id={data.id}
      mainTitle="Editando empresa..."
      pageTitle="Modo edición"
      backUrl={urls.show}
      created_at={formatDate(data.updated_at)}
      updated_at={formatDate(data.updated_at)}
    >
      <Form {...form}>
        <form
          id={`edit-${data.id}`}
          onSubmit={form.handleSubmit(onSubmit)}
          className={CONTAINER_CLASS}
        >
          <div className="space-y-4">
            <FormTitle id="h3-basicos" title="Información Básica" />
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
                />
              )}
            />
            <FormField
              control={form.control}
              name="tel"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Nº Teléfono"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
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
                  value={field.value || ""}
                  options={PERFILES}
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
                  value={field.value || ""}
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
                  value={field.value || ""}
                  {...(field.value === "" && { placeholder: "(Vacío)" })}
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
                  value={field.value || ""}
                  {...(field.value === null && {
                    placeholder: "Sin seleccionar.",
                  })}
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
                  id={field.name}
                  name={field.name}
                  label="Caducidad"
                  value={field.value || null}
                  onChange={field.onChange}
                  {...(field.value === null && { placeholder: "dd/mm/aaaa" })}
                  resetBtn
                  resetFn={() =>
                    form.setValue(field.name, null, {
                      shouldValidate: true,
                      shouldDirty: true,
                      shouldTouch: true,
                    })
                  }
                />
              )}
            />
          </div>
          <div className="col-span-full flex w-full">
            <FormButton type="submit" variant={"default"} className="ml-auto">
              <Save className="mr-3 size-4" />
              Guardar
            </FormButton>
          </div>
        </form>
      </Form>
    </FormLayout>
  );
}
