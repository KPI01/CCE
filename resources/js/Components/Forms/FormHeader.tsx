import { Badge, badgeVariants } from "@/Components/ui/badge";
import { Button } from "@/Components/ui/button";
import { Separator } from "@/Components/ui/separator";
import { cn } from "@/lib/utils";
import { Actions, Urls, UUID } from "@/types";
import { Link } from "@inertiajs/react";
import { ChevronLeft, Pen, Trash } from "lucide-react";

interface Props {
  id?: UUID;
  title: string;
  created?: string | never;
  updated?: string | never;
  urls?: Urls;
  className?: string;
  backUrl?: string;
}

export default function FormHeader({
  title,
  created,
  updated,
  urls,
  backUrl = '#',
  className,
}: Props) {
  // console.debug('route.params:', route().params)
  return (
    <div className={cn("flex items-center gap-4", className)}>
      <Button variant={"outline"} size={"sm"} className="px-2 py-1" asChild>
        <Link as="button" id="back" href={backUrl}>
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
                  href={urls.destroy || '#'}
                  className={badgeVariants({ variant: "destructive" })}
                  as="button"
                >
                  <Trash className="size-3" />
                </Link>
                <Link
                  href={urls.edit || '#'}
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
