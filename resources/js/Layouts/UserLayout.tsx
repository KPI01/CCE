import NavBar from '@/Components/User/NavBar'

import { PropsWithChildren } from 'react'
import { usePage } from '@inertiajs/react'

export default function UserLayout({ children }: PropsWithChildren) {
    const { auth }: any = usePage().props
    console.log(auth)

    return (
        <>
        <NavBar username={auth.user.name} email={auth.user.email} />
        <main className='px-10'>
            {children}
        </main>
        </>
    )
}
