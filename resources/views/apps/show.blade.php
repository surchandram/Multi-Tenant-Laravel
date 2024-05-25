<x-simple-layout>
	<section class="max-w-7xl mx-auto py-16 mb-32 text-gray-800 text-center md:text-left">
		<div class="block">
			<div class="flex flex-wrap items-center">
				<div class="grow-0 shrink-0 basis-auto block lg:flex w-full lg:w-6/12 xl:w-4/12">
					<div class="w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg">
						<div class="flex items-center justify-center mx-auto">
							{{ $app->getFirstMedia('logo') }}
						</div>
					</div>
				</div>

				<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 xl:w-8/12">
					<div class="px-6 py-12 md:px-12">
						<h2 class="text-3xl font-bold mb-6 pb-2">{{ $app->name }}</h2>
						<p class="text-gray-500 mb-6 pb-2">
							{{ $app->description }}
						</p>
						<div class="flex flex-wrap mb-6">
							@forelse ($app->features as $feature)
								<div class="w-full lg:w-6/12 xl:w-4/12 mb-4">
									<p class="flex items-center justify-center md:justify-start">
										<svg class="w-4 h-4 mr-2" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
											<path fill="currentColor"
												d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
											</path>
										</svg>{{ $feature->feature->name }}
									</p>
								</div>
							@empty
								<p class="text-sm text-slate-700">{{ __('No features found.') }}</p>
							@endforelse
						</div>
							
						<button type="button"
							class="inline-block px-7 py-3 bg-gray-800 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out">
							{{ __('Go to app') }}
						</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- features -->
	<div class="container max-w-7xl px-6 md:px-12 mx-auto">
		<section class="mb-32 text-gray-800">
			<div class="flex flex-wrap items-center">
				<div class="grow-0 shrink-0 basis-auto w-full lg:w-4/12 mb-6 md:mb-0 px-3">
					<h2 class="text-3xl font-bold mb-6">
						Why is it so<u class="text-blue-600"> great?</u>
					</h2>

					<p class="text-gray-500 mb-12">
						Nunc tincidunt vulputate elit. Mauris varius purus malesuada neque iaculis malesuada.
						Aenean gravida magna orci, non efficitur est porta id. Donec magna diam.
					</p>
				</div>

				<div class="grow-0 shrink-0 basis-auto w-full lg:w-8/12 mb-6 mb-md-0 px-3">
					<div class="flex flex-wrap">
						<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
							<div class="flex">
								<div class="shrink-0 mt-1">
									<svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
										</path>
									</svg>
								</div>
								<div class="grow ml-4">
									<p class="font-bold mb-1">Support 24/7</p>
									<p class="text-gray-500">
										Pellentesque mollis, metus nec fringilla aliquam. Donec consequat orci quis
										volutpat imperdiet.
									</p>
								</div>
							</div>
						</div>

						<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
							<div class="flex">
								<div class="shrink-0 mt-1">
									<svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
										</path>
									</svg>
								</div>
								<div class="grow ml-4">
									<p class="font-bold mb-1">Tracking</p>
									<p class="text-gray-500">
										Magna lacus iaculis elit, quis pharetra varius. Aenean lectus ex, placerat id
										tellus in eros.
									</p>
								</div>
							</div>
						</div>

						<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
							<div class="flex">
								<div class="shrink-0 mt-1">
									<svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
										</path>
									</svg>
								</div>
								<div class="grow ml-4">
									<p class="font-bold mb-1">Reporting</p>
									<p class="text-gray-500">
										Pellentesque varius ex vel consequat quis. Sed mauris ex, imperdiet sit amet
										nisl ac, ultrices.
									</p>
								</div>
							</div>
						</div>

						<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
							<div class="flex">
								<div class="shrink-0 mt-1">
									<svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
										</path>
									</svg>
								</div>
								<div class="grow ml-4">
									<p class="font-bold mb-1">Analytics</p>
									<p class="text-gray-500">
										Vestibulum gravida iaculis nisl, vel lobortis eros. Praesent vulputate lacus
										bibendum augue.
									</p>
								</div>
							</div>
						</div>

						<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
							<div class="flex">
								<div class="shrink-0 mt-1">
									<svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
										</path>
									</svg>
								</div>
								<div class="grow ml-4">
									<p class="font-bold mb-1">Huge community</p>
									<p class="text-gray-500">
										Praesent vulputate lacus bibendum augue. Pellentesque mollis, metus nec
										fringilla aliquam.
									</p>
								</div>
							</div>
						</div>

						<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
							<div class="flex">
								<div class="shrink-0 mt-1">
									<svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
										</path>
									</svg>
								</div>
								<div class="grow ml-4">
									<p class="font-bold mb-1">Easy to use</p>
									<p class="text-gray-500">
										Sed mauris ex, imperdiet sit amet nisl ac, ultrices. Magna lacus iaculis elit,
										quis pharetra varius.
									</p>
								</div>
							</div>
						</div>

						<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
							<div class="flex">
								<div class="shrink-0 mt-1">
									<svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
										</path>
									</svg>
								</div>
								<div class="grow ml-4">
									<p class="font-bold mb-1">Frequent updates</p>
									<p class="text-gray-500">
										Aenean lectus ex, placerat id tellus in eros. Pellentesque varius ex vel
										consequat quis. Sed mauris ex
									</p>
								</div>
							</div>
						</div>

						<div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 mb-12">
							<div class="flex">
								<div class="shrink-0 mt-1">
									<svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path fill="currentColor"
											d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
										</path>
									</svg>
								</div>
								<div class="grow ml-4">
									<p class="font-bold mb-1">Responsive</p>
									<p class="text-gray-500">
										Donec consequat orci quis volutpat imperdiet. Vestibulum gravida iaculis nisl,
										vel lobortis eros.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</x-simple-layout>
