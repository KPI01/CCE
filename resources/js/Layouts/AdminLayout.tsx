import NavBar from '@/Components/NavBar'

import { PropsWithChildren } from 'react'
import { usePage } from '@inertiajs/react'

export default function AdminLayout({ children }: PropsWithChildren) {
    const { auth }: any = usePage().props
    const isAdmin: boolean = auth.user.role.name === 'Admin'
    console.log(auth)
    console.log(isAdmin)

    return (
        <>
        <NavBar username={auth.user.name} email={auth.user.email} isAdmin={isAdmin}/>
        <main className='px-10'>
            {children}
        </main>
        </>
    )
}
