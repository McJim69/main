# McJim Cyberworks — Development & Contribution Guidelines

Welcome, Amigo! To ensure the codebase remains secure, optimized, and easy to maintain, all additions and refactorings must follow these specific engineering guidelines.

## 📝 Coding Standards

### 1. PHP Version & Type Safety
*   **Target Engine:** PHP 8.0+ strict standards.
*   **Function Definitions:** All parameters must follow positional rules (required parameters cannot follow optional parameters with default values).
*   **Type Hinting:** Use explicit type hints for parameters and return types where possible to make intent clear.

### 2. Security Protocols (Strictly Enforced)
*   **Database Queries:** Never pass raw global inputs directly into queries. Always sanitize URL or form values.
*   **Data Casting:** Force numeric lookup fields to integers using type casting (`(int)$_GET['id']`) to block potential SQL injections at the entry point.
*   **Output Escaping:** Wrap all dynamic echo outputs in `htmlspecialchars()` to mitigate Cross-Site Scripting (XSS) risks inside layout structures.

### 3. Frontend Mechanics & Staging
*   **Interactions:** Prioritize clean, modern interactions—such as drag-and-drop file zones—over rigid form inputs.
*   **Media Galleries:** Use semantic markup configurations compatible with Lightbox2 loops to handle high-resolution image arrays safely.

## 🔒 Version Control Workflow

*   **Secrets Isolation:** Never commit active runtime connection objects (`connect.php`), access tokens, or private service account JSON keys.
*   **Public Verification Tokens:** Verification assets like `ads.txt` and Google Analytics code arrays must remain explicitly tracked by Git to preserve crawler viability.
*   **Commit Quality:** Write short, punchy commit summaries referencing the affected components (e.g., `git commit -m "Fix: Reorder positional arguments in update function"`).
