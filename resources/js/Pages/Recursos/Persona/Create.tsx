import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { Form, FormField, FormLabel } from "@/Components/ui/form";
import {
  CAPACITACIONES,
  formSchema,
  PERFILES,
  TIPOS_ID_NAC,
} from "./formSchema";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import { useState } from "react";
import { router } from "@inertiajs/react";
import { Switch } from "@/Components/ui/switch";
import { Label } from "@radix-ui/react-label";
import { Breadcrumbs } from "@/types";
import { CONTAINER_CLASS, CreateIcon, SendIcon, TablaIcon } from "../utils";
import FormButton from "@/Components/Forms/FormButton";

const schema = formSchema;

export default function Create({ url }: { url: string }) {
  const [showRopo, setFillRopo] = useState<boolean>(false);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: {
      tipo_id_nac: "DNI",
    },
  });

  function handleRopoShow(curr: boolean) {
    let val = !curr;
    setFillRopo(val);
  }

  function onSubmit(values: z.infer<typeof schema>) {
    router.post(url, values);
  }

  const breadcrumb: Breadcrumbs[] = [
    {
      icon: <TablaIcon />,
      text: "Tabla",
      url: url,
    },
    {
      icon: <CreateIcon />,
      text: "Creando...",
      url: `${url}/create`,
    },
  ];

  return (
    <FormLayout
      pageTitle="Creando: Persona"
      mainTitle="Persona"
      url={url}
      breadcrumbs={breadcrumb}
      showActions={false}
    >
      <Form {...form}>
        <form
          id="create-persona"
          className={CONTAINER_CLASS}
          onSubmit={form.handleSubmit(onSubmit)}
        >
          <div className="space-y-4">
            <FormField
              control={form.control}
              name="nombres"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Nombre(s) *"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                />
              )}
            />
            <FormField
              control={form.control}
              name="apellidos"
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label="Apellido(s) *"
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
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
                Identificación *
              </FormLabel>
              <FormField
                control={form.control}
                name="tipo_id_nac"
                render={({ field }) => (
                  <FormItemSelectConstructor
                    id={field.name}
                    name={field.name}
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
                    id={field.name}
                    withLabel={false}
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
                  label="Correo *"
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
                  label="Teléfono"
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
                  name={field.name}
                  label="Perfil"
                  value={field.value || PERFILES[0]}
                  placeholder="Seleccionar perfil..."
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
                  onChange={field.onChange}
                  value={field.value}
                />
              )}
            />
          </div>
          <div className="space-y-8">
            <div className="flex items-center gap-2">
              <Switch
                name="ropo"
                id="show-ropo"
                onClick={() => handleRopoShow(showRopo)}
              />
              <Label className="font-medium" htmlFor="show-ropo">
                ¿Con ROPO?
              </Label>
            </div>
            {showRopo && (
              <div id="ropo-form" className="space-y-4">
                <FormField
                  control={form.control}
                  name="ropo.capacitacion"
                  render={({ field }) => (
                    <FormItemSelectConstructor
                      id={field.name}
                      name={field.name}
                      label="Capacitación"
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
                      label="Identificación"
                      name={field.name}
                      onChange={field.onChange}
                      value={field.value}
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
                      onChange={field.onChange}
                      value={field.value}
                    />
                  )}
                />
              </div>
            )}
          </div>
          <div className="col-span-full w-full">
            <p className="mb-3 ml-auto w-fit text-sm">
              Los campos marcados con (*) son obligatorios
            </p>
            <FormButton type="submit" className="ms-auto">
              <SendIcon />
              Enviar
            </FormButton>
          </div>
        </form>
      </Form>
    </FormLayout>
  );
}
