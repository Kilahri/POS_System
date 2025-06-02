import React, { useState } from "react";
import axios from "../utils/Axiosinstance";

const FeedbackForm: React.FC = () => {
  const [feedback, setFeedback] = useState("");
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState("");

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setMessage("");

    try {
      const response = await axios.post("/feedback", { message: feedback });
      setMessage("Thank you for your feedback!");
      setFeedback("");
    } catch (error) {
      console.error("Feedback error:", error);
      setMessage("Failed to submit feedback. Try again.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="p-4 max-w-md mx-auto bg-white rounded-lg shadow">
      <h2 className="text-xl font-bold mb-4">Send Us Your Feedback</h2>
      <form onSubmit={handleSubmit}>
        <textarea
          value={feedback}
          onChange={(e) => setFeedback(e.target.value)}
          className="w-full border rounded p-2 mb-4"
          rows={5}
          placeholder="Write your feedback here..."
          required
        />
        <button
          type="submit"
          className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          disabled={loading}
        >
          {loading ? "Sending..." : "Submit Feedback"}
        </button>
      </form>
      {message && <p className="mt-4 text-sm text-green-600">{message}</p>}
    </div>
  );
};

export default FeedbackForm;
