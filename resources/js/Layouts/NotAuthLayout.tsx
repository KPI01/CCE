import NavBar from "@/Components/NoAuth/NavBar";

import { PropsWithChildren } from "react";

export default function NoAuthLayout({ children }: PropsWithChildren) {
    const site: string | undefined = route().current() ? route().current() : undefined;

    return (
        <>
            <NavBar site={site} />
            <div className="h-3/4 grid place-content-center">
                {children}
            </div>
        </>
    )
}