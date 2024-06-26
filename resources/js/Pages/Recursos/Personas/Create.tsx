import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/Components/ui/form";
import {
  Select,
  SelectContent,
  SelectTrigger,
  SelectValue,
} from "@/Components/ui/select";
import { SelectItem } from "@/Components/ui/select";
import {
  Popover,
  PopoverTrigger,
  PopoverContent,
} from "@/Components/ui/popover";
import { es } from "date-fns/locale";
import { Calendar } from "@/Components/ui/calendar";
import { router } from "@inertiajs/react";
import { Switch } from "@/Components/ui/switch";
import { Label } from "@/Components/ui/label";
import { useState } from "react";
import { format } from "date-fns";
import { cn } from "@/lib/utils";
import { Save, Trash2, CalendarDays } from "lucide-react";
import {
  formSchema,
  PERFILES,
  TIPOS_APLICADOR,
  TIPOS_ID_NAC,
  TIPOS_ROPO,
} from "./formSchema";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";

const RECURSO = "personas";
const CONTAINER_CLASS = "container grid grid-cols-2 gap-x-32 gap-y-8";

const schema = formSchema;

export default function Create() {
  const [fillRopo, setFillRopo] = useState<boolean>(false);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: {
      tipo_id_nac: "DNI",
    },
  });
  // console.log(form.formState)

  function handleRopoShow(curr: boolean) {
    let val = !curr;
    // console.log('¿Mostrando ROPO?:', curr)
    // console.log('Próximo valor:', val)

    setFillRopo(val);
  }

  function onSubmit(values: z.infer<typeof schema>) {
    console.log(values);

    router.post(route(`${RECURSO}.store`), values);
  }

  return (
    <FormLayout
      pageTitle="Persona"
      mainTitle={`Creando ${RECURSO.slice(0, -1)}...`}
      recurso="personas"
      action="create"
    >
      <Form {...form}>
        <form
          id="create-persona-form"
          className={CONTAINER_CLASS}
          onSubmit={form.handleSubmit(onSubmit)}
        >
          <FormField
            control={form.control}
            name="nombres"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Nombre(s) *"
                name={field.name}
                placeholder="..."
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
                placeholder="..."
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
              className={
                form.getFieldState("id_nac").invalid ? " text-destructive" : ""
              }
              htmlFor="id_nac"
            >
              Identificación *
            </FormLabel>
            <FormField
              control={form.control}
              name="tipo_id_nac"
              render={({ field }) => (
                <FormItemSelectConstructor
                  id={field.name.replace(".", "-")}
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
                placeholder="..."
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
                placeholder="..."
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
                value={field.value as string}
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
                id={field.name}
                label="Observaciones"
                textarea
                name={field.name}
                placeholder="..."
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <div className="col-span-full flex items-center space-x-2">
            <Switch
              name="ropo"
              id="ropo"
              onClick={() => handleRopoShow(fillRopo)}
            />
            <Label htmlFor="ropo">¿Datos ROPO?</Label>
          </div>
          <div
            id="ropo-form"
            className={`col-span-2 grid grid-cols-2 place-content-start gap-x-12 gap-y-4 ${fillRopo ? "" : "hidden"}`}
          >
            <FormField
              control={form.control}
              name="ropo.tipo"
              render={({ field }) => (
                <FormItemSelectConstructor
                  id={field.name.replace(".", "_")}
                  name={field.name}
                  label="Tipo de ROPO"
                  value={field.value as string}
                  placeholder="Seleccionar tipo..."
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
                  id={field.name.replace(".", "_")}
                  label="Nº Carnet"
                  name={field.name}
                  placeholder="..."
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
                  id={field.name.replace(".", "_")}
                  name={field.name}
                  label="Caducidad"
                  onChange={field.onChange}
                  value={field.value}
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
                  options={TIPOS_APLICADOR}
                  value={field.value as string}
                  onChange={field.onChange}
                  name={field.name}
                  placeholder="Selecciona el tipo de aplicador"
                />
              )}
            />
          </div>
          <div className="col-span-2 flex justify-between items-center">
            <Button variant={"destructive"} className="col-span-2" type="reset">
              <Trash2 className="mr-2 h-4" />
              Vaciar
            </Button>
            <Button type="submit">
              <Save className="h-4 mr-2" />
              Crear
            </Button>
          </div>
        </form>
      </Form>
    </FormLayout>
  );
}
