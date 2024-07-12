import FormLayout from "@/Layouts/Recursos/FormLayout";
import {
  CAPACITACIONES,
  CONTAINER_CLASS,
  formSchema,
  PERFILES,
} from "./formSchema";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { Form, FormField } from "@/Components/ui/form";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import { useState } from "react";
import { Switch } from "@/Components/ui/switch";
import { Label } from "@/Components/ui/label";
import FormButton from "@/Components/Forms/FormButton";
import { Save } from "lucide-react";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import { router } from "@inertiajs/react";
import { Urls } from "@/types";

const schema = formSchema;

export default function Create({
  urls,
}: {
  urls: Required<Pick<Urls, "store" | "index">>;
}) {
  const [showRopo, setShowRopo] = useState(false);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: {
      ropo: {
        nro: null,
        caducidad: null,
        capacitacion: null,
      },
    },
  });

  function onSubmit(values: z.infer<typeof schema>) {
    router.post(urls.store, values);
  }

  return (
    <FormLayout
      pageTitle="Empresas"
      mainTitle="Creando empresa..."
      backUrl={route("empresas.index")}
    >
      <Form {...form}>
        <form
          id="create-empresa"
          onSubmit={form.handleSubmit(onSubmit)}
          className={CONTAINER_CLASS}
        >
          <div className="space-y-4">
            <FormField
              control={form.control}
              name="nombre"
              render={({ field }) => (
                <FormItemConstructor
                  label="Nombre *"
                  id={field.name}
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
                  label="NIF *"
                  id={field.name}
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
                  label="Email *"
                  id={field.name}
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
                  label="Teléfono"
                  className="row-span-full"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
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
                  value={field.value}
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
                  placeholder="Selecciona el perfil para la empresa"
                  options={PERFILES}
                  descripcion='Por defecto, se asignará "Aplicador"'
                />
              )}
            />

            <FormField
              control={form.control}
              name="direccion"
              render={({ field }) => (
                <FormItemConstructor
                  label="Dirección"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                  textarea
                />
              )}
            />

            <FormField
              control={form.control}
              name="observaciones"
              render={({ field }) => (
                <FormItemConstructor
                  label="Observaciones"
                  id={field.name}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value || ""}
                  textarea
                />
              )}
            />
          </div>

          <div className="space-y-8">
            <div className="flex items-center gap-x-2">
              <Switch
                name="ropo"
                id="show-ropo"
                onClick={() => setShowRopo(!showRopo)}
              />
              <Label htmlFor="show-ropo">¿Datos ROPO?</Label>
            </div>
            {showRopo && (
              <div id="ropo-form" className="space-y-4">
                <FormField
                  control={form.control}
                  name="ropo.capacitacion"
                  render={({ field }) => (
                    <FormItemSelectConstructor
                      label="Capacitación"
                      id={field.name}
                      name={field.name}
                      onChange={field.onChange}
                      value={field.value || ""}
                      options={CAPACITACIONES}
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
                      value={field.value || null}
                    />
                  )}
                />
              </div>
            )}
          </div>
          <div className="col-span-full">
            <p className="ml-auto w-fit text-sm">
              Los campos marcados con (*) son obligatorios
            </p>
          </div>
          <FormButton type="submit" className="col-span-full ml-auto">
            <Save className="mr-2 size-4" />
            Guardar
          </FormButton>
        </form>
      </Form>
    </FormLayout>
  );
}
