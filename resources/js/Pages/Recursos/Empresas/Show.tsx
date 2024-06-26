import { AccordionContent } from "@/Components/ui/accordion";
import { Card, CardDescription, CardHeader } from "@/Components/ui/card";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Separator } from "@/Components/ui/separator";
import { Textarea } from "@/Components/ui/textarea";
import ShowLayout from "@/Layouts/ShowLayout";
import { Empresa } from "@/types";
import { Link } from "@inertiajs/react";
import {
  Accordion,
  AccordionItem,
  AccordionTrigger,
} from "@radix-ui/react-accordion";
import { PersonIcon } from "@radix-ui/react-icons";

interface Props {
  data: Empresa;
  isAdmin: boolean;
}

function Title({ title }: { title: string }) {
  return <h3 className="font-semibold text-2xl mb-4">{title}</h3>;
}

function ItemProperty({
  title,
  value,
  textarea = false,
}: {
  title: string;
  value: string;
  textarea?: boolean;
}) {
  value = value === null ? "" : value;
  return (
    <div className="grid grid-cols-[8ch_1fr] items-center basis-auto">
      {textarea ? (
        <>
          <div className="grid w-full gap-1.5 col-span-2">
            <Label className="mb-2" htmlFor={`val-${title}`}>
              {title}
            </Label>
            <Textarea
              className="w-full"
              id={`val-${title}`}
              value={value}
              disabled
              cols={35}
              rows={2}
            />
          </div>
        </>
      ) : (
        <>
          <Label htmlFor={`val-${title}`} className="text-start w-fit">
            {title}
          </Label>
          <Input
            id={`val-${title}`}
            className="w-fit me-5"
            type="text"
            disabled
            value={value}
          />
        </>
      )}
    </div>
  );
}

export default function Show(props: Props) {
  console.log(props.data);
  return (
    <ShowLayout
      pageTitle="Empresa"
      title={`${props.data.nombre}`}
      isAdmin={props.isAdmin}
      updated_at={props.data.updated_at}
      recurso="empresa"
    >
      <div className="flex flex-col items-start gap-8 pt-10 px-48">
        <div>
          <Title title="Datos básicos" />
          <div className="flex items-start justify-start gap-3 pt-4 flex-wrap basis-full">
            <ItemProperty title="NIF" value={props.data.nif} />
            <ItemProperty title="Correo" value={props.data.email} />
            <ItemProperty title="Teléfono" value={props.data.tel} />
            <ItemProperty title="Código" value={props.data.codigo} />
            <ItemProperty title="Perfil" value={props.data.perfil} />
          </div>
          <div className="flex items-start gap-x-12 my-12">
            <ItemProperty
              title="Dirección"
              value={props.data.direccion}
              textarea
            />
            <ItemProperty
              title="Observaciones"
              value={props.data.observaciones}
              textarea
            />
          </div>
        </div>
        <div className="w-full">
          <Accordion type="single" collapsible className="w-full">
            {props.data.personas && (
              <>
                <AccordionItem value="personas">
                  <AccordionTrigger>
                    <Title
                      title={`Personas (${props.data.personas?.length})`}
                    />
                  </AccordionTrigger>
                  <AccordionContent className="flex">
                    {props.data.personas?.map((p) => {
                      return (
                        <Link
                          key={p.id}
                          href={route("recurso.persona.show", p.id)}
                          className="w-fit"
                        >
                          <Card className="hover:bg-secondary transition ">
                            <CardHeader className="p-4 font-medium">
                              <div className="flex gap-1 items-center">
                                <PersonIcon />
                                {p.nombres} {p.apellidos}
                              </div>
                              <CardDescription>
                                <span className="font-light ms-4">
                                  {p.tipo_id_nac}: {p.id_nac}
                                </span>
                              </CardDescription>
                            </CardHeader>
                          </Card>
                        </Link>
                      );
                    })}
                  </AccordionContent>
                </AccordionItem>
                <Separator />
              </>
            )}
          </Accordion>
        </div>
      </div>
    </ShowLayout>
  );
}
