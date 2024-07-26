import { Badge, badgeVariants } from "@/Components/ui/badge";
import { Button, buttonVariants } from "@/Components/ui/button";
import { Separator } from "@/Components/ui/separator";
import { cn } from "@/lib/utils";
import { LayoutProps, PageProps } from "@/types";
import { Link, router, usePage } from "@inertiajs/react";
import { ChevronLeft, Pen, Trash } from "lucide-react";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";

interface Props {
  title: string;
  className?: string;
  backUrl?: string;
  deleteUrl?: string;
}

export default function FormHeader({
  title,
  created_at,
  updated_at,
  urls,
  className,
  id,
}: Omit<LayoutProps, "mainTitle" | "pageTitle"> & Props) {
  const { flash, _previous, errors }: PageProps & { errors: Record<string, any> } = usePage<PageProps & { errors: Record<string, any> }>().props;
  console.debug(flash, _previous, errors)
  function handleDelete() {
    if (urls?.destroy) router.delete(urls.destroy);
  }

  return (
    <div className={cn("flex items-center gap-4", className)}>
      <Button variant={"outline"} size={"sm"} className="px-2 py-1" asChild>
        <Link as="button" id="back-btn" href={_previous?.url}>
          <ChevronLeft className="h-4" />
        </Link>
      </Button>
      <Separator orientation="vertical" className="h-10" />
      <div className="flex gap-4">
        <div className="flex flex-col">
          <h1 className="my-3 text-5xl font-extrabold">{title}</h1>
          <div className="flex select-none gap-x-4">
            {urls && (
              <>
                <AlertDialog>
                  <AlertDialogTrigger
                    id={`badge-destroy-${id}`}
                    className={badgeVariants({ variant: "destructive" })}
                  >
                    <Trash className="size-4" />
                  </AlertDialogTrigger>
                  <AlertDialogContent id={`delete-${id}`}>
                    <AlertDialogHeader id="alert-title">
                      <AlertDialogTitle>
                        Confirmación para eliminar
                      </AlertDialogTitle>
                      <AlertDialogDescription>
                        Una vez eliminado, no podrás recuperar el registro.
                        ¿Estás seguro?
                      </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter id="alert-footer">
                      <AlertDialogCancel
                        id="alert-cancel"
                        className={buttonVariants({ variant: "outline" })}
                      >
                        No
                      </AlertDialogCancel>
                      <AlertDialogAction
                        id="alert-confirm"
                        className={buttonVariants({ variant: "destructive" })}
                        onClick={handleDelete}
                      >
                        Sí
                      </AlertDialogAction>
                    </AlertDialogFooter>
                  </AlertDialogContent>
                </AlertDialog>
                <Link
                  href={urls.edit || "#"}
                  id={`badge-edit-${id}`}
                  className={badgeVariants({ variant: "default" })}
                  as="button"
                >
                  <Pen className="size-4" />
                </Link>
              </>
            )}
            {created_at && (
              <Badge variant={"outline"} id={`badge-created-${id}`}>
                Creación: <span className="ml-3 font-thin">{created_at}</span>
              </Badge>
            )}

            {updated_at && (
              <Badge variant={"secondary"} id={`badge-updated-${id}`}>
                Últ. Ed: <span className="ml-3 font-thin">{updated_at}</span>
              </Badge>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
