import axios from 'axios';
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { FaUser, FaLock } from 'react-icons/fa';
import logo from '../../assets/logo.png';



axios.defaults.withCredentials = true; // ✅ Allow sending cookies

function Login() {
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();

    try {
      // Step 1: Get CSRF cookie
      await axios.get('http://localhost:8000/sanctum/csrf-cookie');

      // Step 2: Send login request
      const response = await axios.post('http://localhost:8000/api/auth/profile', {
        email,
        password,
      });

      if (response.data.success) {
        navigate('/dashboard'); // ✅ Redirect on success
      } else {
        setError(response.data.message || 'Login failed');
      }
    } catch (err: any) {
      console.error(err);
      setError(err.response?.data?.message || 'An error occurred');
    }
  };

  return (
    <div className="border border-3 rounded flex min-h-full flex-1 flex-col justify-center py-5"
         style={{ backgroundColor: "#FDF6EC", borderColor: "#A3C585" }}>
      <div className="w-full border-t-3 mb-2 mt-0" style={{ borderColor: "#A3C585" }} />
      <div className="sm:mx-auto sm:w-full sm:max-w-sm mt-2">
        <img alt="POSsibilitea" src={logo} className="mx-auto h-10 w-auto rounded" />
        <h2 className="mt-3 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
          Log in
        </h2>
      </div>
      <div className="mt-5 sm:mx-auto sm:w-full sm:max-w-sm px-10">
        <form onSubmit={handleLogin} className="space-y-6">
          <div>
            <div className="mt-2 relative">
              <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <FaUser />
              </span>
              <input
                type="email"
                required
                value={email}
                onChange={e => setEmail(e.target.value)}
                placeholder="Username"
                className="block w-full rounded-md bg-white pl-10 pr-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
              />
            </div>
          </div>
          <div>
            <div className="mt-2 relative">
              <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <FaLock />
              </span>
              <input
                type="password"
                required
                value={password}
                onChange={e => setPassword(e.target.value)}
                placeholder="Password"
                className="block w-full rounded-md bg-white pl-10 pr-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
              />
            </div>
          </div>
          <div className="flex justify-center">
            <button type="submit" className="mb-2 rounded-md text-black text-xs font-bold py-1 w-fit" style={{ borderColor: "black" }}>
              SIGN IN
            </button>
          </div>
          {error && <p className="text-red-500 text-sm text-center">{error}</p>}
        </form>
      </div>
      <div className="w-full border-t-3 mt-2" style={{ borderColor: "#A3C585" }} />
    </div>
  );
}

export default Login;
