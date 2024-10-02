import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { Form, FormField } from "@/Components/ui/form";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { ucfirst } from "./utils";
import { Button } from "@/Components/ui/button";
import { SaveUpdateIcon } from "@/Pages/Recursos/utils";

interface FormField {
  name: string;
  label: string;
  type: string;
}

interface DynamicFormProps {
  fields: FormField[];
  schema: z.ZodSchema<any>;
  onSubmit: (data: any) => void;
  defaults: Record<string, any>;
}

export default function DynamicForm({
  fields,
  schema,
  onSubmit,
  defaults = {},
}: DynamicFormProps) {
  const form = useForm({
    resolver: zodResolver(schema),
    defaultValues: defaults,
  });

  return (
    <Form {...form}>
      <form
        className="flex flex-col gap-4"
        onSubmit={form.handleSubmit(onSubmit)}
      >
        {fields.map((field) => (
          <div key={field.name}>
            <FormField
              control={form.control}
              name={field.name}
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label={ucfirst(field.name)}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                />
              )}
            />
          </div>
        ))}
        <Button className="ms-auto w-fit" type="submit">
          <SaveUpdateIcon />
          Enviar
        </Button>
      </form>
    </Form>
  );
}
