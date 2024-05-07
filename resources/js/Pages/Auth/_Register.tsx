import NoAuthLayout from "@/Layouts/NotAuthLayout";

import { Head } from "@inertiajs/react";

export default function Register() {
    return (
        <NoAuthLayout>
            <Head title="Nuevo usuario" />
        </NoAuthLayout>
    )
}