import { Badge, badgeVariants } from "@/Components/ui/badge";
import { Button } from "@/Components/ui/button";
import { Separator } from "@/Components/ui/separator";
import { cn } from "@/lib/utils";
import { Actions, PageProps, UUID } from "@/types";
import { Link, usePage } from "@inertiajs/react";
import { ChevronLeft, Pen, Trash } from "lucide-react";

interface Props {
  id?: UUID;
  action: Actions;
  recurso: string;
  title: string;
  created?: string | never;
  updated?: string | never;
  urls?: {
    edit: string;
    destroy: string;
  };
  className?: string;
}

export default function FormHeader({
  id,
  recurso,
  title,
  created,
  updated,
  urls,
  action,
  className,
}: Props) {
  // console.debug('route.params:', route().params)

  const param = recurso.slice(0, -1);
  // console.debug('param:', param);
  // console.debug('test:', { [param]: id });
  let backRouting: string;

  // const { previous } = usePage<PageProps>().props;
  // console.debug('previous:', previous);

  if (action === "show") {
    backRouting = route(`${recurso}.index`);
  } else if (action === "edit") {
    backRouting = route(`${recurso}.show`, { [param]: id });
  } else if (!["create", "index"].includes(action)) {
    backRouting = route(`${recurso}.${action}`, { [param]: id });
  } else {
    backRouting = route(`${recurso}.${action}`);
  }
  // console.debug('backRouting:', { [param]: backRouting });

  return (
    <div className={cn("flex items-center gap-4", className)}>
      <Button variant={"outline"} size={"sm"} className="px-2 py-1" asChild>
        <Link href={backRouting}>
          <ChevronLeft className="h-4" />
        </Link>
      </Button>
      <Separator orientation="vertical" className="h-10" />
      <div className="flex gap-4">
        <div className="flex flex-col">
          <h1 className="font-extrabold text-5xl my-3">{title}</h1>
          <div className="flex gap-x-4 select-none">
            {urls && (
              <>
                <Link
                  href={urls.destroy}
                  className={badgeVariants({ variant: "destructive" })}
                  as="button"
                >
                  <Trash className="size-3" />
                </Link>
                <Link
                  href={urls.edit}
                  className={badgeVariants({ variant: "default" })}
                  as="button"
                >
                  <Pen className="size-3" />
                </Link>
              </>
            )}
            {created && (
              <Badge variant={"outline"} className="">
                Creación: <span className="ml-3 font-thin">{created}</span>
              </Badge>
            )}

            {updated && (
              <Badge variant={"secondary"} className="">
                Últ. Ed: <span className="ml-3 font-thin">{updated}</span>
              </Badge>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
