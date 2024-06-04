import AdminLayout from '@/Layouts/AdminLayout'

import { Head } from '@inertiajs/react'

export default function Dashboard()
{
    return (
        <AdminLayout>
            <Head title='Home' />
            <h2>Bienvenido a tu Dashboard</h2>
        </AdminLayout>
    )
}
