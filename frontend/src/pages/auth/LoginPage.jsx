import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

export default function LoginPage() {
  const { login } = useAuth();
  const navigate = useNavigate();
  const [form, setForm] = useState({ email: '', password: '' });
  const [error, setError] = useState('');

  const submit = async (e) => {
    e.preventDefault();
    try { await login(form); navigate('/'); } catch { setError('Invalid credentials'); }
  };

  return <form onSubmit={submit} className="mx-auto mt-16 max-w-md card space-y-4">
    <h2 className="text-xl font-bold">Sign in</h2>
    <input className="w-full rounded bg-zinc-800 p-2" placeholder="Email" onChange={(e) => setForm({...form,email:e.target.value})} />
    <input type="password" className="w-full rounded bg-zinc-800 p-2" placeholder="Password" onChange={(e) => setForm({...form,password:e.target.value})} />
    {error && <p className="text-red-400">{error}</p>}
    <button className="w-full rounded bg-brand-gold p-2 font-semibold text-black">Login</button>
    <p className="text-sm text-zinc-400">No account? <Link to="/register" className="text-brand-gold">Register</Link></p>
  </form>;
}
