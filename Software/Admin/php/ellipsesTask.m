% Define the functions
f1 = @(x, y) (x - 2)^2 + (y - 3 + 2*x)^2 - 5;
f2 = @(x, y) 2*(x - 3).^2 + (y/3).^2 - 4;
% Draw the ellipses
% Plot the ellipses in standard form
figure;
theta = linspace(0, 2*pi, 100);

% Ellipse 1
x1 = 2 + sqrt(5) * cos(theta);
y1 = 3 - 2*x1 + sqrt(5) * sin(theta);
plot(x1, y1, 'b', 'LineWidth', 0.9);
hold on;

% Ellipse 2
x2 = 3 + sqrt(2) * cos(theta);
y2 = 6 * sin(theta);
plot(x2, y2, 'g', 'LineWidth', 0.9);
title('Ellipse Intersection Plot');
xlabel('x');
ylabel('y');
axis equal; % Ensure equal scaling on both axes
grid on;
% Define the derivatives of the functions
df1_dx = @(x, y) 2*(x - 2) + 2*(y - 3 + 2*x)*2;
df1_dy = @(x, y) 2*(y - 3 + 2*x);
df2_dx = @(x, y) 4*(x - 3);
df2_dy = @(x, y) (2/3)*y;
% Newton's method for finding intersections
e = 0.001; % Error tolerance
max_iterations = 1000; % Maximum number of iterations
initial_guesses = [5, 5; 2, -2; 3, 0; -1, 2]; % Initial guesses for the intersections
intersection_points = []; % To store the found intersection points
% Perform intersection calculations
for j = 1:size(initial_guesses, 1)
x_guess = initial_guesses(j, 1);
y_guess = initial_guesses(j, 2);
for i = 1:max_iterations
% Evaluate the functions and derivatives at the current guess
f1_val = f1(x_guess, y_guess);
f2_val = f2(x_guess, y_guess);
df1_dx_val = df1_dx(x_guess, y_guess);
df1_dy_val = df1_dy(x_guess, y_guess);
df2_dx_val = df2_dx(x_guess, y_guess);
df2_dy_val = df2_dy(x_guess, y_guess);
% Construct the Jacobian matrix and function vector
J = [df1_dx_val, df1_dy_val; df2_dx_val, df2_dy_val];
F = [f1_val; f2_val];
% Solve for the update vector using the pseudoinverse
delta = - pinv(J) * F;
% Update the guess
x_guess = x_guess + delta(1);
y_guess = y_guess + delta(2);
% Check for convergence
if norm(delta) < e
intersection_points = [intersection_points; x_guess, y_guess];
break; % Exit the loop once an intersection is found
end
end
end
% Display and plot the intersection points
disp('Intersection points:');
disp(intersection_points);
scatter(intersection_points(:, 1), intersection_points(:, 2), 'ro', 'filled');
%text(intersection_points(:, 1), intersection_points(:, 2), ...
% num2str(intersection_points), 'VerticalAlignment', 'bottom', ...
% 'HorizontalAlignment', 'right');