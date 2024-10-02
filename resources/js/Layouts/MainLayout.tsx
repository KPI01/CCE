import { StrictMode, useEffect } from "react";
import { usePage } from "@inertiajs/react";
import { cn } from "@/lib/utils";
import { Flash, MainLayoutProps } from "@/types";
import NavBar from "@/Components/NavBar";
import { Toaster } from "@/Components/ui/toaster";
import { useToast } from "@/Components/ui/use-toast";
import { Separator } from "@/Components/ui/separator";
import { TooltipProvider } from "@/Components/ui/tooltip";

export default function MainLayout({ children, className }: MainLayoutProps) {
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
      <NavBar />
      <Separator />
      <TooltipProvider>
        <main className={cn("container flex flex-col", className)}>
          {children}
        </main>
      </TooltipProvider>
      <Toaster />
    </StrictMode>
  );
}
