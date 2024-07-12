import { StrictMode, useEffect } from "react";
import { usePage } from "@inertiajs/react";
import { cn } from "@/lib/utils";
import { Flash, MainLayoutProps } from "@/types";
import NavBar from "@/Components/NavBar";
import { Toaster } from "@/Components/ui/toaster";
import { useToast } from "@/Components/ui/use-toast";

export default function MainLayout({ children, className }: MainLayoutProps) {
  const { auth }: any = usePage().props;
  const isAdmin: boolean = auth.user.role.name === "Admin";

  const { toast } = useToast();
  const pageProps = usePage().props;
  const flash = pageProps.flash as Flash;

  useEffect(() => {
    if (flash.message?.toast) {
      toast({
        variant: flash.message.toast?.variant,
        title:
          flash.message.toast?.title !== undefined
            ? flash.message.toast?.title
            : "",
        description: flash.message.toast?.description,
      });
    }
  }, [flash]);

  return (
    <StrictMode>
      <NavBar
        username={auth.user.name}
        email={auth.user.email}
        isAdmin={isAdmin}
      />
      <main className={cn("container flex flex-col", className)}>
        {children}
      </main>
      <Toaster />
    </StrictMode>
  );
}
