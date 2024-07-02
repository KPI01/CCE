import { StrictMode } from "react";

import { usePage } from "@inertiajs/react";

import { cn } from "@/lib/utils";
import { MainLayoutProps } from "@/types";

import NavBar from "@/Components/NavBar";
import { Toaster } from "@/Components/ui/toaster";

export default function MainLayout({ children, className }: MainLayoutProps) {
  const { auth, errors, flash }: any = usePage().props;
  const isAdmin: boolean = auth.user.role.name === "Admin";
  // console.log(auth)
  // console.log(isAdmin)
  // if (previous) console.debug(previous);
  // if (flash) console.debug(flash);
  // if (errors) console.error(errors);
  console.debug(usePage().props);

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
