// Beautiful Home Page Animations
document.addEventListener("DOMContentLoaded", () => {
  // Navbar scroll effect
  const navbar = document.querySelector(".navbar")

  window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
      navbar.classList.add("scrolled")
    } else {
      navbar.classList.remove("scrolled")
    }
  })

  // Animate stats on scroll
  const observerOptions = {
    threshold: 0.5,
    rootMargin: "0px 0px -100px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        if (entry.target.classList.contains("stat-number")) {
          animateNumber(entry.target)
        }
        if (entry.target.classList.contains("chart-bars")) {
          animateChartBars(entry.target)
        }
        if (entry.target.classList.contains("feature-card")) {
          entry.target.style.animationDelay = Math.random() * 0.5 + "s"
          entry.target.classList.add("animate-in")
        }
      }
    })
  }, observerOptions)

  // Observe elements
  document.querySelectorAll(".stat-number").forEach((el) => observer.observe(el))
  document.querySelectorAll(".chart-bars").forEach((el) => observer.observe(el))
  document.querySelectorAll(".feature-card").forEach((el) => observer.observe(el))

  // Animate numbers
  function animateNumber(element) {
    const target = Number.parseInt(element.textContent)
    const duration = 2000
    const step = target / (duration / 16)
    let current = 0

    const timer = setInterval(() => {
      current += step
      if (current >= target) {
        current = target
        clearInterval(timer)
      }
      element.textContent = Math.floor(current)
    }, 16)
  }

  // Animate chart bars
  function animateChartBars(chartContainer) {
    const bars = chartContainer.querySelectorAll(".bar")
    bars.forEach((bar, index) => {
      setTimeout(() => {
        bar.style.animation = "growUp 1s ease-out forwards"
      }, index * 100)
    })
  }

  // Smooth scroll for demo buttons
  document.querySelectorAll(".demo-pill").forEach((button) => {
    button.addEventListener("click", function (e) {
      // Add loading state
      const originalContent = this.innerHTML
      this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Loading...</span>'

      // Reset after a short delay (for demo purposes)
      setTimeout(() => {
        this.innerHTML = originalContent
      }, 1000)
    })
  })

  // Parallax effect for floating shapes
  window.addEventListener("scroll", () => {
    const scrolled = window.pageYOffset
    const shapes = document.querySelectorAll(".floating-shape")

    shapes.forEach((shape, index) => {
      const speed = 0.5 + index * 0.1
      const yPos = -(scrolled * speed)
      shape.style.transform = `translateY(${yPos}px)`
    })
  })

  // Add hover effects to buttons
  document.querySelectorAll(".btn-primary-custom").forEach((button) => {
    button.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-3px) scale(1.02)"
    })

    button.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0) scale(1)"
    })
  })

  // Floating cards animation
  const floatingCards = document.querySelectorAll(".floating-card")
  floatingCards.forEach((card, index) => {
    // Random floating animation
    setInterval(
      () => {
        const randomX = (Math.random() - 0.5) * 10
        const randomY = (Math.random() - 0.5) * 10
        card.style.transform = `translate(${randomX}px, ${randomY}px)`
      },
      3000 + index * 1000,
    )
  })

  // Add CSS for animate-in class
  const style = document.createElement("style")
  style.textContent = `
        .feature-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .feature-card.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        .btn-primary-custom {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .floating-shape {
            transition: transform 0.1s ease-out;
        }
    `
  document.head.appendChild(style)

  // Add loading animation to CTA button
  document.querySelector(".cta-section .btn-primary-custom")?.addEventListener("click", function (e) {
    if (this.href.includes("register")) {
      const shine = this.querySelector(".btn-shine")
      if (shine) {
        shine.style.left = "100%"
        setTimeout(() => {
          shine.style.left = "-100%"
        }, 500)
      }
    }
  })
})

// Add some extra sparkle effects
function createSparkle() {
  const sparkle = document.createElement("div")
  sparkle.className = "sparkle"
  sparkle.style.cssText = `
        position: fixed;
        width: 4px;
        height: 4px;
        background: #6366f1;
        border-radius: 50%;
        pointer-events: none;
        z-index: 9999;
        animation: sparkleAnimation 1s ease-out forwards;
    `

  const style = document.createElement("style")
  style.textContent = `
        @keyframes sparkleAnimation {
            0% {
                opacity: 1;
                transform: scale(0) rotate(0deg);
            }
            50% {
                opacity: 1;
                transform: scale(1) rotate(180deg);
            }
            100% {
                opacity: 0;
                transform: scale(0) rotate(360deg);
            }
        }
    `
  document.head.appendChild(style)

  document.body.appendChild(sparkle)

  setTimeout(() => {
    sparkle.remove()
  }, 1000)
}

// Add sparkles on button hover
document.addEventListener("mouseover", (e) => {
  if (e.target.classList.contains("btn-primary-custom")) {
    for (let i = 0; i < 3; i++) {
      setTimeout(() => {
        const rect = e.target.getBoundingClientRect()
        const sparkle = document.createElement("div")
        sparkle.style.cssText = `
                    position: fixed;
                    left: ${rect.left + Math.random() * rect.width}px;
                    top: ${rect.top + Math.random() * rect.height}px;
                    width: 3px;
                    height: 3px;
                    background: white;
                    border-radius: 50%;
                    pointer-events: none;
                    z-index: 9999;
                    animation: sparkleFloat 1s ease-out forwards;
                `

        const sparkleStyle = document.createElement("style")
        sparkleStyle.textContent = `
                    @keyframes sparkleFloat {
                        0% {
                            opacity: 1;
                            transform: translateY(0) scale(1);
                        }
                        100% {
                            opacity: 0;
                            transform: translateY(-20px) scale(0);
                        }
                    }
                `
        document.head.appendChild(sparkleStyle)

        document.body.appendChild(sparkle)

        setTimeout(() => {
          sparkle.remove()
          sparkleStyle.remove()
        }, 1000)
      }, i * 100)
    }
  }
})
