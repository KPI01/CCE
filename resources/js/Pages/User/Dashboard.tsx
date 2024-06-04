import UserLayout from '@/Layouts/UserLayout'

import { Head } from '@inertiajs/react'

export default function Dashboard()
{
    return (
        <UserLayout>
            <Head title='Home' />
            <h2>Bienvenido a tu Dashboard</h2>
        </UserLayout>
    )
}
