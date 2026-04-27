import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

export default function RegisterPage() {
  const { register } = useAuth();
  const navigate = useNavigate();
  const [form, setForm] = useState({ business_name: '', business_location: '', name: '', email: '', password: '', password_confirmation: '' });

  const submit = async (e) => {
    e.preventDefault();
    await register(form);
    navigate('/');
  };

  return <form onSubmit={submit} className="mx-auto mt-8 max-w-xl card grid gap-3">
    <h2 className="text-xl font-bold">Create SaaS account</h2>
    {Object.keys(form).map((key) => (
      <input key={key} type={key.includes('password') ? 'password' : 'text'} className="rounded bg-zinc-800 p-2" placeholder={key.replaceAll('_', ' ')} onChange={(e) => setForm({ ...form, [key]: e.target.value })} />
    ))}
    <button className="rounded bg-brand-gold p-2 font-semibold text-black">Register</button>
  </form>;
}
